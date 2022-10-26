<?php

namespace Lucasfarroni\EloquentProject\query;
use ciasie\hellokant\connection\ConnectionFactory;
use PDO;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';


    private function _construct($table)
    {
        $this->sqltable = $table;
    }

    public function table($table)
    {
    $query = new Query($table);
    return $query;
    }

    public function select ( $fields){
        $this->fields = implode(',',$fields);
        return $this;
    }

    public function where($col,$op,$val){
        if(!is_null($this->where))$this->where = 'and';
        $this->args[]=$val;
        return $this;
    }
    public function get(){
        $this->sql = 'select'. $this->fields.'from'.$this->sqltable;
        if(!is_null($this->where))
            $this->sql .= 'where'.$this->where;
        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
/*
 $conf = parse_ini_file('conf.ini');
 ConnectionFactory::makeConnection($conf);

 $q = Query::table('article')
     ->select(['id','nom','descr','tarif'])
     ->where('tarif','<',1000);
 $res  = $q->get();
*/
