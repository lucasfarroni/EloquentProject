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

    public function __get(){}


    public  function __set(){}

}