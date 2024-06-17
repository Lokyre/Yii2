<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

POSTMAN
------------
https://documenter.getpostman.com/view/31740286/2sA3XS9fi6


INSTALLATION
------------

### Instalar via Composer

Si no tienes [Composer](https://getcomposer.org/), sigues las siguientes instrucciones
at [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

Instala - Crea el proyecto con este comando
~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~


CONFIGURACION
-------------

### Database

Edita `config/db.php`

```php
return [
    'class' => 'yii\mongodb\Connection',
    'dsn' => 'mongodb://localhost:27017/yiibd',
    //'username' => 'root',
    //'password' => '1234',
    //'charset' => 'utf8',
];
```

### Running  acceptance tests

1. Update dependencies with Composer 

    ```
    composer update  
    ```

2. Start web server:

    ```
    tests/bin/yii serve
    ```
3. Accede atravez de
    ~~~
    http://localhost/basic/web/
    ~~~
