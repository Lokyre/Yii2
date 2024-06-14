<?php

namespace app\controllers;

use Yii;
use app\models\Autor;
use yii\rest\ActiveController;
use yii\web\Response;

class AutorController extends ActiveController
{
    public $modelClass = 'app\models\Autor';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
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
        return Autor::find()->all();
    }

    private function findModel($id)
    {
        if (is_numeric($id)) {
            return Autor::findOne(['_id' => intval($id)]);
        } else {
            return Autor::findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
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
        $model = new Autor();
        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->validate() && $model->save()) {
            return $model;
        } else {
            return ['errors' => $model->errors];
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model !== null) {
            $model->load(Yii::$app->request->getBodyParams(), '');
            if ($model->validate() && $model->save()) {
                return $model;
            } else {
                return $model->getErrors();
            }
        } else {
            throw new \yii\web\NotFoundHttpException('Autor no encontrado');
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model !== null) {
            $model->delete();
            return ['status' => 'Autor eliminado correctamente.'];
        } else {
            throw new \yii\web\NotFoundHttpException("Autor con ID $id no encontrado.", 404);
        }
    }
}
