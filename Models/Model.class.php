<?php

abstract class BDConnexion{
    private static $pdo;

    private static function setBDD(){
        self::$pdo = new PDO('mysql:host=localhost;dbname=biblio;port=3308;charset=utf8', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getBDD(){
        if (self::$pdo === null){
            self::setBDD();
        }
        return self::$pdo;
    }
}