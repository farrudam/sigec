<?php
namespace sigec\database;

class DBSigec {

    /** @var \PDO */
    private static $keys = null;

//    private function __construct() {
//
//    }

    /**
     * @return \PDO
     */
//    public static function getkeys() {
//        if(self::$keys == null) {
//            $senha = '80#wise!ARMY$happy';
//            self::$keys = new \PDO("pgsql:host=localhost port=5432 dbname=keys user=postgres password=$senha");
////            self::$phoenix = new \PDO("pgsql:host=10.0.5.6 dbname=phoenix user=postgres password=IBMpostgreS", array(
////                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
////                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
////            ));
//            self::$keys->setAttribute(\PDO::ATTR_STATEMENT_CLASS, ['models\DBStatement', [self::$keys]]);
//        }
//        return self::$keys;
//    }
    
     
    public static function getKeys() {
        $username = 'sati';
        $password = '3czs91ADVuDJBqTW';
        $host = 'localhost';
        $dbname = 'sati_sigec';
        if(self::$keys == null) {
            self::$keys = new \PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password, [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
            self::$keys->setAttribute(\PDO::ATTR_STATEMENT_CLASS, ['sigec\database\DBStatement', [self::$keys]]);
        }
        return self::$keys;
    }

}