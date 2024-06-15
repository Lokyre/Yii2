<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use app\components\AuthComponent;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $username = Yii::$app->request->getBodyParam('username');
        $password = Yii::$app->request->getBodyParam('password');

        $user = User::findByUsername($username);
        if (!$user || !$user->validatePassword($password)) {
            return ['error' => 'Credenciales inválidas.'];
        }

        // Obtener instancia del componente AuthComponent
        $authComponent = new AuthComponent();

        // Generar un nuevo token JWT
        $token = $authComponent->generateToken($user->id);

        return ['token' => $token];
    }

    // Ejemplo de una acción protegida
    public function actionProtected()
    {
        $user = Yii::$app->user->identity; // Obtener el usuario autenticado

        return [
            'message' => 'Esta es una acción protegida',
            'user' => $user, // Puedes devolver información del usuario si es necesario
        ];
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');

        if (!$username || !$password) {
            throw new BadRequestHttpException('Missing required parameters: username, password');
        }

        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            return ['message' => 'Usuario creado exitosamente.'];
        } else {
            return ['error' => 'Error al crear el usuario.', 'errors' => $user->errors];
        }
    }
}
