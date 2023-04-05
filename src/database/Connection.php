<?php

//namespace sigec\config\database;
//
//use PDO;
//use PDOException;
//
//class Connection{
//    private static $instancia = null;
//
//    public static function getInstancia():PDO
//    {
//        if (empty(self::$instancia)){
//
//            try {
//                if (self::$instancia === null){
//                    self::$instancia = new PDO('mysql:host=localhost;port=3306;dbname=sigec', 'root', '');
//                }                
//
//            } catch (PDOException $ex) {
//                die('Erro de conexão:: '.$ex->getMessage());
//            }
//
//            return self::$instancia;
//        }
//    }
//
//}
