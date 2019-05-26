<?php

class DB{

    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "madeira_madeira";

    private static $instance;

    public static function getInstance(){
        if(!isset(self::$instance)){
            try {
                self::$instance = new PDO('mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB, self::DB_USER, self::DB_PASSWORD);

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$instance;
    }

    public static function executar($sql){
        return self::getInstance()->prepare($sql);
    }
}