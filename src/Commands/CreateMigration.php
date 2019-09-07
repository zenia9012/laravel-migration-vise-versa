<?php

namespace Yevhenii\LaravelMigrationViseVersa\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\GeneratorCommand;
use Yevhenii\LaravelMigrationViseVersa\Helpers\DbColumns;
use Yevhenii\LaravelMigrationViseVersa\Helpers\CommandsTrait;
use Yevhenii\LaravelMigrationViseVersa\Helpers\ColumnsConvector;

/**
 * List all locally installed packages.
 *
 * @author JeroenG
 **/
class CreateMigration extends GeneratorCommand {

    use CommandsTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:migration {name} {--m : create model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration from existing table.';

    protected $type = 'Migration';

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $table = $this->getNameInput();

        $path = $this->getPath($table);

        $stub = $this->getStubString($path);

        $stub = $this->replaceTableName($stub, $table);

        $columnsConvector = new ColumnsConvector($stub);

        $stub = $columnsConvector->replaceMigration($table);

        $this->files->put($path, $stub);

        if ($this->option('m')) {
            $this->call('table:model', ['name' => $table]);
        }

        $this->info($this->type . ' created successfully.');

    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/migration.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $date = Carbon::now();

        $fileName = $date->format('Y_m_d_His') . '_create_' . $name . '_table.php';

        return database_path('migrations/') . $fileName;
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

        $class = 'Create' . Str::ucfirst($class) . 'Table';

        return str_replace('DummyClass', $class, $stub);
    }

    protected function replaceTableName($stub, $name)
    {
        $name = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace('DummyTable', $name, $stub);
    }
}
