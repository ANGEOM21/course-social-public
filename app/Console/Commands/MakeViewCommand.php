<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeViewCommand extends Command
{
    protected $signature = 'make:view {name} {--p|pages}';
    protected $description = 'Generate a Blade view file with optional pages path';

    public function handle(): void
    {
        $name = str_replace('.', '/', $this->argument('name'));

        $basePath = $this->option('pages') ? 'views/pages/' : 'views/';
        $fullPath = resource_path($basePath . $name . '.blade.php');

        $template = str_replace(
            ['{name}', '{name_title}', '{app_name}'],
            [class_basename($name), ucwords(str_replace(['-', '_'], ' ', class_basename($name))), config('app.name')],
            $this->getStub()
        );


        if (File::exists($fullPath)) {
            $this->error("❌ View already exists: {$fullPath}");
            return;
        }

        File::ensureDirectoryExists(dirname($fullPath));

        File::put($fullPath, $template);

        $this->info("✅ View created at: " . str_replace(base_path(), '', $fullPath));
    }


    protected function getStub()
    {
        return file_get_contents(resource_path('stubs/view-page.stub'));
    }

}
