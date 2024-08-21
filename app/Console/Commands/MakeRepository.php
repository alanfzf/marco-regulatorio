<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepository extends Command
{
    protected $files;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {ModelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('ModelName');
        $directory = app_path("Repositories/{$modelName}");

        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $this->createClass($modelName, $directory, 'repository', "{$modelName}Repository.php");
        $this->createClass($modelName, $directory, 'repository_interface', "{$modelName}RepositoryInterface.php");

        $this->info("Repository and Interface created successfully for model {$modelName}.");
    }

    protected function createClass($modelName, $directory, $stubName, $fileName)
    {
        $stubPath = base_path("stubs/{$stubName}.stub");
        $content = $this->files->get($stubPath);

        $content = str_replace('{{ModelName}}', $modelName, $content);

        $filePath = "{$directory}/{$fileName}";
        $this->files->put($filePath, $content);
    }
}
