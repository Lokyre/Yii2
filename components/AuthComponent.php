<?php

namespace app\components;

use Yii;
use yii\base\Component;
use Firebase\JWT\JWT;
use yii\web\UnauthorizedHttpException;

class AuthComponent extends Component
{
    const EXPIRATION_TIME = 1800; // 30 minutos

    private $secretKey = "89M+yJYt5DnEGHhrMIT0QKaG9AcKWy6TlOquL0j+hes=";
    private $algorithm = 'HS256'; // Algoritmo de cifrado


    public function generateToken($userId)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 1800;  // 30 minutos de tiempo de expiración
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId
        );
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    public function validateToken($token)
    {
        try {
            JWT::decode($token, $this->secretKey, array($this->algorithm));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
