<?php


namespace Yevhenii\LaravelMigrationViseVersa\Helpers;


use Illuminate\Support\Facades\DB;

class ColumnsConvector {

    /**
     * @var string
     */
    private $stub;

    private $replacer = StubReplacer::class;

    /**
     * ColumnsConvector constructor.
     *
     * @param array $columns
     * @param       $stub
     */
    public function __construct(string $stub)
    {
        $this->stub = $stub;
    }

    /**
     * @param string $table
     * @param array  $exceptColumns
     * @return mixed
     */
    public function replaceModel(string $table, array $exceptColumns): string
    {
        $columns = DbColumns::getListColumns($table);

        $columns = $this->deleteExceptColumn($columns, $exceptColumns);

        return $this->replacer::replaceModelColumns($this->stub, $columns);
    }

    public function replaceMigration(string $table): string
    {
        $columns = DbColumns::getColumns($table);
        dump($columns);
        $tableConvector = new TableTypeConvector();

        $str = '';
        foreach ($columns as $column) {
            $str .= $tableConvector->getString($column);
        }

        return $this->replacer::replaceMigrationColumns($this->stub, $str);
    }

    protected function deleteExceptColumn($columns, $exceptColumns)
    {
        foreach ($exceptColumns as $exceptColumn) {
            foreach ($columns as $key => $column) {
                if ($exceptColumn == $column) {
                    unset($columns[$key]);
                }
            }
        }

        return $columns;
    }


}
