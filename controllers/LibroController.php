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
         $behaviors['authenticator'] = [
             'class' => HttpBearerAuth::className(),
         ];
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
            'add-author' => ['PUT'],
        ];
    }


    public function actionIndex()
    {
        return Libro::find()->all();
    }

    // Método para encontrar un libro por su ID y lanzar una excepción si no se encuentra
    protected function findModel($id)
    {
        $model = Libro::findOne($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('El libro solicitado no existe.');
        }
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

    // Método adicional para agregar un autor a un libro
    public function actionAddAuthor($id)
    {
        $libro = $this->findModel($id);
        $autorId = Yii::$app->request->bodyParams['autor_id'];
    
        $autores = is_array($libro->autores) ? $libro->autores : [];
        if (!in_array($autorId, $autores)) {
            $autores[] = $autorId;
            $libro->autores = $autores;
        }
    
        // Establece el escenario de actualización antes de guardar
        $libro->scenario = Libro::SCENARIO_UPDATE;
    
        if ($libro->save()) {
            return $libro;
        } else {
            return ['errors' => $libro->errors];
        }
    }


}
