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

    public function insert($t){
        $this->sql = 'insert into' .$this->sqltable;
        $into = [];
        $values = [];
        foreach ($t as $attname => $attval){
            $into[]=$attname;
            $values[]='?';
            $this->args[]=$attval;
        }
        $this->sql .= '('. implode(',',$into ).')'.
            'values ('. implode(',', $values).')';
        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return (int)$pdo->lastInsertId($this->sqltable);
    }


   public function one(){
        $this->sql = 'select'.$this->fields.'from'.$this->sqltable;
       if(!is_null($this->where))
           $this->sql .='LIMIT 1';

       $pdo = ConnectionFactory::getConnection();
       $stmt = $pdo->prepare($this->sql);
       $stmt->execute($this->args);
       $fetchAll=$stmt->fetchAll(PDO::FETCH_ASSOC);
       return $fetchAll[0];
   }

   public function getQuery() {
        return ['query'=> $this->sql,
                'args'=>$this->args];

   }

}
/*$testTable = 'article';
$test = new Query($testTable);
$test->table($testTable);
var_dump($test);*/
/*
 $conf = parse_ini_file('conf.ini');
 ConnectionFactory::makeConnection($conf);

 $q = Query::table('article')
     ->select(['id','nom','descr','tarif'])
     ->where('tarif','<',1000);
 $res  = $q->get();
*/
