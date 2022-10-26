<?php

namespace EloquenProject\model;

class Article extends Model
{
    protected static $table = 'article';
    protected static $idColumn = 'id';

    public function categorie()
    {
        return $this->belongsTo('\models\Categorie', 'id_categ');
    }
}