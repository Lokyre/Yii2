<?php

namespace app\models;

use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['yiibd', 'users']; // Reemplaza 'your_database_name' con el nombre de tu base de datos
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['_id', 'username', 'password_hash', 'auth_key'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['username'], 'unique'],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * Encuentra una identidad por el ID de usuario.
     * @param string|int $id El ID de usuario.
     * @return IdentityInterface|null La identidad que coincide con el ID de usuario.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Encuentra una identidad por el token de autenticación.
     * @param string $token El token de autenticación.
     * @param mixed $type El tipo de token.
     * @return IdentityInterface|null La identidad que coincide con el token de autenticación.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implementar la búsqueda de la identidad usando el token
        // En este caso, no usaremos tokens de acceso directamente, sino JWT
        return null;
    }

    /**
     * Encuentra un usuario por el nombre de usuario.
     * @param string $username El nombre de usuario.
     * @return static|null El usuario que coincide con el nombre de usuario.
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return (string)$this->_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Valida la contraseña.
     * @param string $password La contraseña a validar.
     * @return bool Si la contraseña proporcionada es válida para el usuario actual.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Genera el hash de la contraseña y lo guarda en el modelo.
     * @param string $password La contraseña a hashear.
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Genera una clave de autenticación "recuerdame".
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
