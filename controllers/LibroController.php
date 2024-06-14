<?php

namespace app\controllers;

use Yii;
use app\models\Libro;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth; // Importa esto si estás usando autenticación bearer token

class LibroController extends ActiveController
{
    public $modelClass = 'app\models\Libro';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        // Añadir autenticación si es necesaria
        // $behaviors['authenticator'] = [
        //     'class' => HttpBearerAuth::className(),
        // ];
        return $behaviors;
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }


    public function actionIndex()
    {
        return Libro::find()->all();
    }
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException("Object not found: $id");
        }
    }

    public function actionCreate()
    {
        $model = new Libro();
        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        } else {
            return $model->getErrors();
        }
    }

    public function actionUpdate($id)
    {
        $model = Libro::findOne($id);
        if ($model !== null) {
            $model->load(Yii::$app->request->getBodyParams(), '');
            if ($model->save()) {
                error_log('Libro actualizado con éxito: ' . $model->id);
                return $model;
            } else {
                error_log('Error al actualizar el libro: ' . print_r($model->getErrors(), true));
                return $model->getErrors();
            }
        } else {
            throw new \yii\web\NotFoundHttpException('Libro no encontrado');
        }
    }

    public function actionDelete($id)
    {
        $model = Libro::findOne($id);
        if ($model !== null) {
            $model->delete();
            return 'Libro eliminado correctamente.';
        } else {
            return 'Libro no encontrado.';
        }
    }


}
