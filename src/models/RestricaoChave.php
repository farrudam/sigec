<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Chave;
use sigec\models\Usuario;

class RestricaoChave{
                
    private $id_chave;
    private $chave;
    
    private $mat_solic;
    private $usuario;
    
    public function __construct($id_chave = null, $mat_solic = null) {        
        $this->id_chave = $id_chave;
        $this->mat_solic = $mat_solic;        
    }
    
    private function bundle ($row){  
        
        $chave =  new Chave($row['id_chave']);        
        $usuario = new Usuario($row['mat_solic']);
        
        $restricao_chave = new RestricaoChave($row['id_chave'], $row['mat_solic']);  

        $restricao_chave->setChave($chave->getById($row['id_chave']));
        $restricao_chave->setUsuario($usuario->getByMatricula($row['mat_solic']));               
                
        return $restricao_chave;
    }  
    
    static function create($params) {
        $sql = "INSERT INTO restricao_chave (id_chave, mat_solic) VALUES (?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['id_chave'],  
            $params['mat_solic']            
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id_chave, $mat_solic) {
        $sql = 'DELETE FROM restricao_chave WHERE id_chave = ? and mat_solic = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_chave, $mat_solic));
        return $stmt->errorInfo();
    } 
    
    static function getRestricoesByChave($id_chave) {
        $sql = "select * from restricao_chave where id_chave = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_chave));
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = self::bundle($row);
        }
        return $result;
    }    
    
    static function getAllSemRestricao($id_chave) {
        //$sql = "select * from restricao_chave where id_chave = ?";
        $sql = "SELECT * 
                FROM usuario 
                WHERE matricula 
                NOT IN ( SELECT mat_solic
                        FROM restricao_chave
                        WHERE id_chave = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_chave));
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = self::bundle($row);
        }
        return $result;
    }
    
    public function getChave() {
        return $this->chave;
    }    
    
    public function getIdChave() {
        return $this->id_chave;
    }
    
    public function getUsuario() {
        return $this->usuario;
    } 

    public function getIdUsuario() {
        return $this->mat_solic;
    }    
    
    public function setChave($chave) {
        $this->chave = $chave;
    }    
    
    public function setIdChave($id_chave) {
        $this->id_chave = $id_chave;
    }
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setIdUsuario($mat_solic) {
        $this->mat_solic = $mat_solic;
    }
    
    
    //    public function getAll() {
//        $sql = "select * from restricao_chave order by mat_solic";
//        $stmt = DBSigec::getKeys()->prepare($sql);
//        $stmt->execute(array());
//        $rows = $stmt->fetchAll();
//        $result = array();
//        foreach ($rows as $row) {
//            array_push($result, self::bundle($row));
//        }
//        return $result;
//    }
    
//    public function getById() {
//        $sql = "SELECT * from item_emprestimo WHERE id_emprestimo = ? and id_chave = ?";
//        $stmt = DBSigec::getKeys()->prepare($sql);
//        $stmt->execute(array($this->id_chave, $this->id_chave));
//        $row = $stmt->fetch();
//        if ($row == null) {
//            return null;
//        }
//        return self::bundle($row);
//    }
    
    
}