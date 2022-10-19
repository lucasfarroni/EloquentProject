<?php

use ciasie\hellokant\connection\ConnectionFactory;

$conf = parse_ini_file("conf.ini");

$ConnectionFactory = New ConnectionFactory();
try{
    $ConnectionFactory::makeConnection($conf);
}catch (\ciasie\hellokant\connection\DBException $exception){
    echo $exception;
}
