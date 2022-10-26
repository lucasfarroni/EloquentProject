<?php
namespace \EloquentProject\model;

class Model
{
    protected static $table;
    protected static $idColumn = 'id';

    protected $_v = [];
    protected static $query;

    public function __construct(array $t = null)
    {
        if (!is_null($t)) {

            $this->_v = $t;

        }
    }

    public function __get(string $name): mixed
    {
        if (array_key_exists($name, $this->_v))
            return $this->_v[$name];
    }

    public function __set(string $name, mixed $val): void
    {
        $this→_v[$name] = $val;
    }

}