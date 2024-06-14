<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\mongodb\Exception as MongoDBException;

class HelloController extends Controller
{
    public function actionInit()
    {
        try {
            // Obtener la conexión a MongoDB desde Yii
            $connection = Yii::$app->db;

            // Verificar la conexión
            $connection->open();

             // Verificar si la conexión ya está abierta
             if (!$connection->getIsActive()) {
                $connection->open();
            }
            echo "Conexión exitosa a MongoDB.\n";

            return Controller::EXIT_CODE_NORMAL;
        } catch (MongoDBException $e) {
            echo "Error al conectar a MongoDB: " . $e->getMessage() . "\n";
            return Controller::EXIT_CODE_ERROR;
        }
    }
}
