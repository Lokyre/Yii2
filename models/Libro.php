<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Libro extends ActiveRecord
{
    const SCENARIO_UPDATE = 'update';

    public static function collectionName()
    {
        return 'libros';
    }

    public function attributes()
    {
        return ['_id', 'titulo', 'autores', 'anio_publicacion', 'descripcion'];
    }

    public function rules()
    {
        return [
            [['titulo', 'anio_publicacion', 'descripcion'], 'required', 'message' => 'El campo {attribute} es obligatorio.'],
            [['anio_publicacion'], 'date', 'format' => 'php:Y', 'message' => 'El año de publicación debe ser una fecha y tener el formato YYYY.'],
            [['autores'], 'safe'],
            ['titulo', 'validateTitulo', 'except' => self::SCENARIO_UPDATE],
            ['descripcion', 'validateDescripcion', 'except' => self::SCENARIO_UPDATE],

        ];
    }

    public function getAutores()
    {
        return $this->hasMany(Autor::className(), ['_id' => 'autor_id']);
    }

    public function messages()
    {
        return [
            'anio_publicacion.date' => 'La fecha de publicacion debe ser un año.',
            'titulo.string' => 'El nombre completo debe ser una cadena de texto sin tildes ni caracteres especiales.',
            'titulo.max' => 'El nombre completo no puede tener más de 255 caracteres.',
            'descripcion.string' => 'La descripcion debe ser una cadena de texto sin tildes ni caracteres especiales.',
            'descripcion.max' => 'La descripcion no puede tener más de 255 caracteres.',
        ];
    }

    public function validateTitulo($attribute, $params)
    {
        $messages = $this->messages();
        if (!is_string($this->$attribute) || !preg_match('/^[a-zA-Z\s]+$/', $this->$attribute)) {
            $this->addError($attribute, $messages['titulo.string']);
        } elseif (strlen($this->$attribute) > 255) {
            $this->addError($attribute, $messages['titulo.max']);
        }
    }

    public function validateDescripcion($attribute, $params)
    {
        $messages = $this->messages();
        if (!is_string($this->$attribute) || !preg_match('/^[a-zA-Z\s]+$/', $this->$attribute)) {
            $this->addError($attribute, $messages['descripcion.string']);
        } elseif (strlen($this->$attribute) > 255) {
            $this->addError($attribute, $messages['descripcion.max']);
        }
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }
}
