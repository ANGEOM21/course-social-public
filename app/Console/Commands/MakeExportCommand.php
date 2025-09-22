<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeExportCommand extends Command
{
    protected $signature = 'make:export-geom {name}';
    protected $description = 'Generate export class and views for PDF and Excel';

    public function handle()
    {
        $name = $this->argument('name'); // Misal: Penduduk
        $slug = Str::kebab($name);       // => penduduk
        $className = Str::studly($name) . 'Export'; // PendudukExport

        $exportPath = app_path("Exports/{$className}.php");
        $viewDir = resource_path("views/export/{$slug}");
        $tableView = "{$viewDir}/table.blade.php";
        $pdfView = "{$viewDir}/pdf/content.blade.php";

        // Cek file export
        if (File::exists($exportPath)) {
            $this->error("Export class already exists: {$exportPath}");
            return;
        }

        // Buat class export
        File::ensureDirectoryExists(dirname($exportPath));
        File::put($exportPath, $this->getExportStub($name, $slug));
        $this->info("Created: {$exportPath}");

        // Buat view
        File::ensureDirectoryExists($viewDir);
        File::put($tableView, $this->getTableViewStub());
        File::ensureDirectoryExists("{$viewDir}/pdf");
        File::put($pdfView, $this->getPdfViewStub($slug));
        $this->info("Created: {$tableView}");
        $this->info("Created: {$pdfView}");
    }

    protected function getExportStub($name, $slug)
    {
        $className = Str::studly($name) . 'Export';
        return str_replace(
            ['{className}', '{slug}'],
            [$className, $slug],
            $this->getStub('class-pdf')
        );
    }

    protected function getTableViewStub()
    {
        return $this->getStub('table-pdf');
    }

    protected function getPdfViewStub($slug)
    {
        return str_replace(
            ['{slug}'],
            [$slug],
            $this->getStub('view-pdf')
        );
    }

    protected function getStub($stub)
    {
        return file_get_contents(resource_path("stubs/export-pdf/$stub.stub"));
    }
}
