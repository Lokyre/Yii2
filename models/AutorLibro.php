<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class AutorLibro extends ActiveRecord
{
    public static function collectionName()
    {
        return 'autor_libro';
    }

    public function attributes()
    {
        return ['_id', 'autor_id', 'libro_id'];
    }

    public function rules()
    {
        return [
            [['autor_id', 'libro_id'], 'required'],
        ];
    }

    public function getAutor()
    {
        return $this->hasOne(Autor::className(), ['_id' => 'autor_id']);
    }

    public function getLibro()
    {
        return $this->hasOne(Libro::className(), ['_id' => 'libro_id']);
    }
}
