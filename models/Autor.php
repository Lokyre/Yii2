<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Autor extends ActiveRecord
{
    public static function collectionName()
    {
        return 'autores';
    }

    public function attributes()
    {
        return ['_id', 'nombre', 'fecha_nacimiento', 'libros_escritos'];
    }

    public function rules()
    {
        return [
            [['nombre', 'fecha_nacimiento'], 'required', 'message' => 'El campo {attribute} es obligatorio.'],
            [['libros_escritos'], 'safe'],
            ['fecha_nacimiento', 'date', 'format' => 'php:d-m-Y', 'message' => 'La fecha de nacimiento debe ser una fecha y tener el formato dd-mm-YYYY.'],
            ['nombre', 'validateNombre'],
        ];
    }

    public function getLibrosEscritos()
    {
        return $this->hasMany(Libro::className(), ['_id' => 'libro_id'])->via('librosEscritosRelacion');
    }

    public function messages()
    {
        return [
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha.',
            'nombre.string' => 'El nombre completo debe ser una cadena de texto sin tildes ni caracteres especiales.',
            'nombre.max' => 'El nombre completo no puede tener más de 255 caracteres.',
        ];
    }
    public function validateNombre($attribute, $params)
    {
        $messages = $this->messages();
        if (!is_string($this->$attribute) || !preg_match('/^[a-zA-Z\s]+$/', $this->$attribute)) {
            $this->addError($attribute, $messages['nombre.string']);
        } elseif (strlen($this->$attribute) > 255) {
            $this->addError($attribute, $messages['nombre.max']);
        }
    }
}

