<?php

class Categorie extends Model
{
    protected static $table = 'categorie';
    protected static $idColumn = 'id';

    public function articles()
    {
        return $this->hasMany('models\Article', 'id_categ');
    }
}
