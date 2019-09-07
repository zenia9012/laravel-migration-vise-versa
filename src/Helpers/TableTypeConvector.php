<?php


namespace Yevhenii\LaravelMigrationViseVersa\Helpers;


use phpDocumentor\Reflection\Types\Iterable_;

class TableTypeConvector {

    private $start = '$table->';
    private $end = ';' . PHP_EOL . "            ";
    private $count;

    public function getString(\stdClass $column)
    {
        $type = $column->Type;
        $this->count = 0;

        preg_match('#\((.*?)\)#', $type, $count);
        if (isset($count[1])){
            $this->count = $count[1];

            $type = str_replace('(' . $this->count . ')', '', $type);
        }

        $type = explode(' ', $type);
        $type = $type[0];

        $str = '';

        if (method_exists(new self, $type)){
            $str = $this->$type($column->Field);

            return $this->start . $str .$this->end;
        }

        return $str;
    }

    protected function varchar($name){
        return 'string(\'' . $name . '\')';
    }

    protected function bigint($name)
    {
        return 'bigIncrements(\'' . $name . '\')';
    }

    protected function timestamp($name)
    {
        return 'timestamp(\'' . $name . '\')';
    }

    protected function json($name){
        return 'json(\'' . $name . '\')';
    }
}
