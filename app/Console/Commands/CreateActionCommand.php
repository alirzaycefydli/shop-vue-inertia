<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Signature('make:action {name}')]
#[Description('Create a new action class')]
final class CreateActionCommand extends Command
{
    public function handle(): int
    {
        $name = str_replace('\\', '/', $this->argument('name'));

        $className = Str::studly(class_basename($name));

        $directory = dirname($name);

        $namespace = 'App\\Actions';

        if ($directory !== '.') {
            $namespace .= '\\'.str_replace('/', '\\', $directory);
        }

        $path = app_path(
            'Actions/'.$name.'.php'
        );

        if (File::exists($path)) {
            $this->error("Action {$className} already exists.");

            return self::FAILURE;
        }

        File::ensureDirectoryExists(dirname($path));

        File::put(
            $path,
            $this->getStubContent($namespace, $className)
        );

        $this->info("Action {$className} created successfully.");

        return self::SUCCESS;
    }

    protected function getStubContent(string $namespace, string $className): string
    {
        $stub = file_get_contents(base_path('stubs/action.stub'));

        return str_replace(
            [
                'DummyNamespace',
                'DummyClass',
            ],
            [
                $namespace,
                $className,
            ],
            $stub
        );
    }
}
