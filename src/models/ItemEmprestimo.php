<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Emprestimo;
use sigec\models\Chave;

class ItemEmprestimo{
    
    private $devolvido_em;    
    
    private $id_emprestimo;
    private $emprestimo;
        
    private $id_chave;
    private $chave;
    
    public function __construct($id_emprestimo, $id_chave) {
        $this->id_emprestimo = $id_emprestimo;
        $this->id_chave = $id_chave;
    }
    
    private function bundle ($row){        
             
        $emprestimo = new Emprestimo($row['id_emprestimo']);
        $chave = new Chave($row['id_chave']);

        $item_emprestimo = new ItemEmprestimo($row['id_emprestimo'], $row['id_chave']);        
        
        $item_emprestimo->setDevolvidoEm($row['devolvido_em']);       
        
        $item_emprestimo->setIdEmprestimo($row['id_emprestimo']);  
        $item_emprestimo->setEmprestimo($emprestimo->getById('id_emprestimo'));
    
        return $emprestimo;
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
        $sql = "INSERT INTO item_emprestimo (id_emprestimo, id_chave) VALUES (?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['id_emprestimo'],  
            $params['id_chave']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id) {
        $sql = 'DELETE FROM item_emprestimo WHERE id_emprestimo = ? and id_chave = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function update($params) {
        $sql = "UPDATE item_emprestimo set devolvido_em = ? WHERE id_emprestimo = ? and id_chave = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute($params['devolvido_em'], $this->id_emprestimo, $this->id_chave);
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

    public function getIdChave() {
        return $this->id_chave;
    }

    public function setDevolvidoEm($devolvido_em) {
        $this->devolvido_em = $devolvido_em;
    }

    public function setEmprestimo($emprestimo) {
        $this->usuario = $usuario;
    }

    public function setIdEmprestimo($id_emprestimo) {
        $this->id_emprestimo = $id_emprestimo;
    } 

    public function setChave($chave) {
        $this->chave = $chave;
    }    

    public function setIdChave($id_chave) {
        $this->id_chave = $id_chave;
    }
    
}