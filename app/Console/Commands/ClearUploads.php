<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ClearUploads extends Command
{
    protected $signature = 'storage:clear {--all : Also clear persistent uploaded files (destructive)}';
    protected $description = 'Clear temporary storage files. Use --all to clear everything (destructive).';

    public function handle()
    {
        $directories = [
            storage_path('app/public'),
            storage_path('app/private'),
        ];

        $tempNames = ['temp', 'tmp', 'temporary', 'cache'];

        if (!$this->option('all')) {
            $this->warn('Safe mode enabled: only temporary/cache folders will be removed.');
            $this->line('Use --all if you explicitly want to remove persistent uploaded files.');
        }

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                $this->warn("Directory does not exist: {$directory}");
                continue;
            }

            if ($this->option('all')) {
                $files = File::allFiles($directory);
                $subDirs = File::directories($directory);

                foreach ($files as $file) {
                    if ($file->getFilename() !== '.gitignore') {
                        File::delete($file->getPathname());
                    }
                }

                foreach ($subDirs as $dir) {
                    File::deleteDirectory($dir);
                }

                $this->info("Cleared all files in: {$directory}");
                continue;
            }

            $removed = 0;

            foreach (File::directories($directory) as $dir) {
                $baseName = Str::lower(basename($dir));
                if (in_array($baseName, $tempNames, true)) {
                    File::deleteDirectory($dir);
                    $removed++;
                }
            }

            foreach (File::files($directory) as $file) {
                $name = Str::lower($file->getFilename());
                if ($name !== '.gitignore' && (Str::contains($name, 'tmp') || Str::contains($name, 'temp') || Str::contains($name, 'cache'))) {
                    File::delete($file->getPathname());
                    $removed++;
                }
            }

            $this->info("Cleared {$removed} temporary entries in: {$directory}");
        }

        return self::SUCCESS;
    }
}
