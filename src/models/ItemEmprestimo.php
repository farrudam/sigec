<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Emprestimo;
use sigec\models\Chave;
use sigec\models\Usuario;

class ItemEmprestimo{
    
    private $devolvido_em;    
    
    private $id_emprestimo;
    private $emprestimo;
        
    private $id_chave;
    private $chave;
    
    private $mat_user;
    private $usuario;
    
    public function __construct($id_emprestimo = null, $id_chave = null, $mat_user = null) {
        $this->id_emprestimo = $id_emprestimo;
        $this->id_chave = $id_chave;
        $this->mat_user = $mat_user;
    }
    
    private function bundle ($row){      
        
        $emprestimo = new Emprestimo($row['id_emprestimo']);
        
        $chave =  new Chave($row['id_chave']);
        
        $usuario = new Usuario($row['mat_user']);
        
        $item_emprestimo = new ItemEmprestimo($row['id_emprestimo'], $row['id_chave'], $row['mat_user']);  
        $item_emprestimo->setEmprestimo($emprestimo->getById());
        $item_emprestimo->setDevolvidoEm($row['devolvido_em']);  
        
        $item_emprestimo->setChave($chave->getById($row['id_chave']));
        $item_emprestimo->setUsuario($usuario->getByMatricula($row['mat_user']));
        
        return $item_emprestimo;
    }
    
    public function getAll() {
        $sql = "select * from item_emprestimo order by id_emprestimo";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result;
    }
    
    static function getByEmprestimo($id_emprestimo) {
        $sql = "select * from item_emprestimo where id_emprestimo = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_emprestimo));
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = self::bundle($row);
        }
        return $result;
    }

    public function getById() {
        $sql = "SELECT * from item_emprestimo WHERE id_emprestimo = ? and id_chave = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id_emprestimo, $this->id_chave));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }

    static function create($params) {
        var_dump($params);
        die();
        $sql = "INSERT INTO item_emprestimo (id_emprestimo, id_chave) VALUES (?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['id_emprestimo'],  
            $params['id_chave']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id_emprestimo, $id_chave) {
       
        $sql = 'DELETE FROM item_emprestimo WHERE id_emprestimo = ? and id_chave = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id_emprestimo, $this->id_chave));
        return $stmt->errorInfo();
    }

    static function devolver($id_emprestimo, $id_chave, $mat_user) {      
         
        $sql = "UPDATE item_emprestimo "
                . "SET devolvido_em = CURRENT_TIME(), item_emprestimo.mat_user = ? "
                . "WHERE item_emprestimo.id_emprestimo = ? AND item_emprestimo.id_chave = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($mat_user, $id_emprestimo, $id_chave));        
        return $stmt->errorInfo();
    }
    
    
    static function setDevolucaoChaves($mat_user, $id_emprestimo) {
        $sql = "UPDATE item_emprestimo "
                . "SET devolvido_em = CURRENT_TIME(),"
                . "item_emprestimo.mat_user = ? "
                . "WHERE item_emprestimo.id_emprestimo = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($mat_user, $id_emprestimo));        
        return $stmt->errorInfo();
    }

    public function getDevolvidoEm() {
        return $this->devolvido_em;
    }
    
    public function getEmprestimo() {
        return $this->emprestimo;
    }    

    public function getIdEmprestimo() {
        return $this->id_emprestimo;
    }

    public function getChave() {
        return $this->chave;
    }    
    
    public function getUsuario() {
        return $this->usuario;
    } 

    public function getIdChave() {
        return $this->id_chave;
    }

    public function setDevolvidoEm($devolvido_em) {
        $this->devolvido_em = $devolvido_em;
    }

    public function setEmprestimo($emprestimo) {
        $this->emprestimo = $emprestimo;
    }

    public function setIdEmprestimo($id_emprestimo) {
        $this->id_emprestimo = $id_emprestimo;
    } 

    public function setChave($chave) {
        $this->chave = $chave;
    }    
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setIdChave($id_chave) {
        $this->id_chave = $id_chave;
    }
    
}