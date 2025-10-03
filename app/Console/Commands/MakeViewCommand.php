<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name} {--p|pages} {--class=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Blade view and an optional associated class with a custom name/path';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if ($this->option('class') !== null) {
            $this->createClassAndAssociatedView();
        } else {
            $this->createOnlyView();
        }
    }

    /**
     * Logic to create only the view file.
     *
     * @return void
     */
    protected function createOnlyView(): void
    {
        $name = str_replace('.', '/', $this->argument('name'));
        $basePath = $this->option('pages') ? 'views/pages/' : 'views/';
        $fullPath = resource_path($basePath . $name . '.blade.php');

        if (File::exists($fullPath)) {
            $this->error("❌ View already exists: {$fullPath}");
            return;
        }

        $template = str_replace(
            ['{name}', '{name_title}', '{app_name}'],
            [class_basename($name), ucwords(str_replace(['-', '_'], ' ', class_basename($name))), config('app.name')],
            $this->getStub('view-page')
        );

        File::ensureDirectoryExists(dirname($fullPath));
        File::put($fullPath, $template);
        $this->info("✅ View created at: " . str_replace(base_path(), '', $fullPath));
    }

    /**
     * Logic to create both the class and the view file.
     *
     * @return void
     */
    protected function createClassAndAssociatedView(): void
    {
        $nameArgument = $this->argument('name');
        $viewNameForClass = $this->option('pages') ? 'pages.' . $nameArgument : $nameArgument;
        $viewPathName = str_replace('.', '/', $nameArgument);

        // --- 1. Persiapan Path dan Nama ---

        $classOption = $this->option('class');
        $baseNamespace = rtrim(config('livewire.class_namespace', 'App\\Http\\Livewire'), '\\');
        $className = '';
        $classNamespace = '';

        // Kasus 1: Nama kelas disediakan (--class=Admins/Courses atau --class=CourseIndex)
        if (is_string($classOption) && !empty($classOption)) {
            // Normalisasi separator untuk konsistensi
            $classInput = str_replace('\\', '/', $classOption);

            // Ekstrak nama kelas (bagian terakhir dari path)
            $className = Str::studly(basename($classInput));

            // Ekstrak sub-direktori (jika ada)
            $classSubdirectory = dirname($classInput);

            // Buat sub-namespace jika ada sub-direktori
            $subNamespace = '';
            if ($classSubdirectory !== '.') {
                $subNamespace = '\\' . str_replace('/', '\\', $classSubdirectory);
            }
            
            // Gabungkan base namespace dengan sub-namespace
            $classNamespace = $baseNamespace . $subNamespace;
        }
        // Kasus 2: Hanya --class diberikan, buat nama default dari path view
        else {
            $className = Str::studly($nameArgument);
            $classNamespace = $baseNamespace;
        }

        // --- 2. Tentukan Path File ---
        $classPath = app_path(str_replace(['App\\', '\\'], ['', '/'], $classNamespace) . '/' . $className . '.php');
        $viewBasePath = $this->option('pages') ? 'views/pages/' : 'views/';
        $viewFullPath = resource_path($viewBasePath . $viewPathName . '.blade.php');

        // --- 3. Validasi File ---
        if (File::exists($classPath)) {
            $this->error("❌ Class already exists: {$classPath}");
            return;
        }
        if (File::exists($viewFullPath)) {
            $this->error("❌ View already exists: {$viewFullPath}");
            return;
        }

        // --- 4. Buat View ---
        $viewTemplate = str_replace(
            ['{name}', '{name_title}', '{app_name}'],
            [class_basename($viewPathName), ucwords(str_replace(['-', '_'], ' ', class_basename($viewPathName))), config('app.name')],
            $this->getStub('view-page-class')
        );

        File::ensureDirectoryExists(dirname($viewFullPath));
        File::put($viewFullPath, $viewTemplate);
        $this->info("✅ View created at: " . str_replace(base_path(), '', $viewFullPath));

        // --- 5. Buat Class ---
        $classTemplate = str_replace(
            ['{namespace_classes}', '{clases}', '{view_page}'],
            [$classNamespace, $className, $viewNameForClass],
            $this->getStub('namespace-class-view')
        );
        
        // ensureDirectoryExists akan membuat folder Admins secara rekursif jika belum ada
        File::ensureDirectoryExists(dirname($classPath));
        File::put($classPath, $classTemplate);
        $this->info("✅ Class created at: " . str_replace(base_path(), '', $classPath));
    }

    /**
     * Get the specified stub file content.
     *
     * @param string $stubName
     * @return string
     */
    protected function getStub(string $stubName): string
    {
        $path = resource_path("stubs/{$stubName}.stub");
        if (!File::exists($path)) {
            $this->error("Stub file not found at: {$path}");
            return '';
        }
        return file_get_contents($path);
    }
}