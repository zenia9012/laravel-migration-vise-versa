<?php

namespace Yevhenii\LaravelMigrationViseVersa\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\GeneratorCommand;
use Yevhenii\LaravelMigrationViseVersa\Helpers\DbColumns;
use Yevhenii\LaravelMigrationViseVersa\DB\MigrationConvector;
use Yevhenii\LaravelMigrationViseVersa\Helpers\CommandsTrait;
use Yevhenii\LaravelMigrationViseVersa\Helpers\ColumnsConvector;

/**
 * List all locally installed packages.
 *
 * @author JeroenG
 **/
class CreateModel extends GeneratorCommand {

    use CommandsTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:model {name} {--except=id : except column} {--m : create migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model from existing table.';

    protected $type = 'Model';

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $table = $this->getNameInput();

        $exceptColumn = $this->getExceptColumnInput();

        $path = $this->getPath($table);

        $stub = $this->getStubString($path);

        $stub = $this->replaceTableName($stub, $table);

        $columnsConvector = new ColumnsConvector($stub);

        $stub = $columnsConvector->replaceModel($table, $exceptColumn);

        $this->files->put($path, $stub);

        if ($this->option('m')) {
            $this->call('table:migration', ['name' => $table]);
        }

        $this->info($this->type . ' created successfully.');

    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $fileName = 'Model/' . Str::ucfirst(Str::singular($name));

        return $this->laravel['path'] . '/' . str_replace('\\', '/', $fileName) . '.php';
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        $class = Str::ucfirst(Str::singular($class));

        return str_replace('DummyClass', $class, $stub);
    }

    protected function replaceTableName($stub, $name)
    {
        return str_replace('DummyTable', $name, $stub);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return array
     */
    protected function getExceptColumnInput()
    {
        return explode(',', $this->option('except'));
    }
}
