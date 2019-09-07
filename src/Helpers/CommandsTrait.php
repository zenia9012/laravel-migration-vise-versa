<?php


namespace Yevhenii\LaravelMigrationViseVersa\Helpers;


trait CommandsTrait {

    /**
     * @param $path
     * @return string
     */
    public function getStubString($path)
    {
        $name = $this->qualifyClass($this->getNameInput());

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        return $this->buildClass($name);
    }
}
