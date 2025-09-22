<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DbGenerateMigrations extends Command
{
    protected $signature = 'db:generate-migrations {--tables=*}';
    protected $description = 'Generate migration files from existing database schema';

    public function handle()
    {
        $database = DB::getDatabaseName();
        $tablesOption = $this->option('tables');

        if (empty($tablesOption)) {
            $tableObjs = DB::select("SELECT table_name as name FROM information_schema.tables WHERE table_schema = ?", [$database]);
            $tables = array_map(fn($t) => $t->name, $tableObjs);
        } else {
            $tables = $tablesOption;
        }

        foreach ($tables as $table) {
            $columns = DB::select("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, EXTRA, COLUMN_KEY FROM information_schema.columns WHERE table_schema = ? AND table_name = ?", [$database, $table]);

            $foreigns = DB::select("SELECT kcu.COLUMN_NAME, kcu.REFERENCED_TABLE_NAME, kcu.REFERENCED_COLUMN_NAME, rc.UPDATE_RULE, rc.DELETE_RULE
                FROM information_schema.KEY_COLUMN_USAGE kcu
                JOIN information_schema.REFERENTIAL_CONSTRAINTS rc
                  ON kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME
                  AND kcu.CONSTRAINT_SCHEMA = rc.CONSTRAINT_SCHEMA
                WHERE kcu.TABLE_SCHEMA = ? AND kcu.TABLE_NAME = ? AND kcu.REFERENCED_TABLE_NAME IS NOT NULL", [$database, $table]);

            $migrationName = 'create_' . $table . '_table';
            $className = Str::studly($migrationName);
            $filename = date('Y_m_d_His') . '_' . $migrationName . '.php';

            $stub = "<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('$table', function (Blueprint \$table) {
";

            foreach ($columns as $col) {
                if ($col->COLUMN_NAME === 'id' && str_contains($col->EXTRA, 'auto_increment')) {
                    $stub .= "            \$table->id();\n";
                    continue;
                }

                $type = $this->mapColumnType($col);

                if ($type === 'enum') {
                    $enumValues = $this->extractEnumValues($col->COLUMN_TYPE);
                    $valueString = '[' . implode(', ', array_map(fn($v) => "'{$v}'", $enumValues)) . ']';
                    $line = "            \$table->enum('{$col->COLUMN_NAME}', $valueString)";
                } else {
                    $line = "            \$table->$type('{$col->COLUMN_NAME}')";
                }

                if ($col->IS_NULLABLE === 'YES') {
                    $line .= '->nullable()';
                }
                if ($col->COLUMN_DEFAULT !== null && $col->COLUMN_DEFAULT !== 'CURRENT_TIMESTAMP') {
                    $default = is_numeric($col->COLUMN_DEFAULT) ? $col->COLUMN_DEFAULT : "'{$col->COLUMN_DEFAULT}'";
                    $line .= "->default($default)";
                }
                if ($col->COLUMN_DEFAULT === 'CURRENT_TIMESTAMP') {
                    $line .= "->useCurrent()";
                }
                if (str_contains($col->EXTRA, 'auto_increment')) {
                    $line .= "->autoIncrement()";
                }
                if ($col->COLUMN_KEY === 'UNI') {
                    $line .= "->unique()";
                }

                $stub .= $line . ";\n";
            }

            foreach ($foreigns as $fk) {
                $fkLine = "            \$table->foreign('{$fk->COLUMN_NAME}')"
                    . "->references('{$fk->REFERENCED_COLUMN_NAME}')"
                    . "->on('{$fk->REFERENCED_TABLE_NAME}')";

                if (strtolower($fk->DELETE_RULE) === 'cascade') {
                    $fkLine .= "->onDelete('cascade')";
                }
                if (strtolower($fk->UPDATE_RULE) === 'cascade') {
                    $fkLine .= "->onUpdate('cascade')";
                }

                $stub .= $fkLine . ";\n";
            }

            $stub .= "        });\n    }

    public function down(): void
    {
        Schema::dropIfExists('$table');
    }
};\n";

            File::put(database_path("migrations/" . $filename), $stub);
            $this->info("Generated migration: $filename");
        }
    }

    protected function mapColumnType($col): string
    {
        $type = strtolower($col->DATA_TYPE);
        $ctype = strtolower($col->COLUMN_TYPE);

        return match (true) {
            $type === 'bigint' && str_contains($ctype, 'unsigned') => 'unsignedBigInteger',
            $type === 'bigint' => 'bigInteger',
            $type === 'int', $type === 'integer' => 'integer',
            $type === 'smallint' => 'smallInteger',
            $type === 'mediumint' => 'mediumInteger',
            $type === 'tinyint' && $col->COLUMN_TYPE === 'tinyint(1)' => 'boolean',
            $type === 'tinyint' => 'tinyInteger',
            $type === 'varchar', $type === 'char' => 'string',
            $type === 'text', $type === 'mediumtext', $type === 'longtext' => 'text',
            $type === 'json' => 'json',
            $type === 'datetime' => 'dateTime',
            $type === 'date' => 'date',
            $type === 'time' => 'time',
            $type === 'timestamp' => 'timestamp',
            $type === 'float' => 'float',
            $type === 'double' => 'double',
            $type === 'decimal' => 'decimal',
            $type === 'enum' => 'enum',
            $type === 'blob' || $type === 'binary' => 'binary',
            default => 'string',
        };
    }

    protected function extractEnumValues($columnType): array
    {
        preg_match('/enum\((.*)\)/i', $columnType, $matches);
        if (!isset($matches[1])) return [];

        return array_map(fn($v) => trim($v, " '"), explode(',', $matches[1]));
    }
}
