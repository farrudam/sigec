<?php

namespace sigec\models;
use sigec\database\DBSigec;

class Bloco{

    private $id;
    private $nome;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    private function bundle ($row){
        $bloco = new Bloco($row['id']);
        $bloco->setNome($row['nome']);
        
        return $bloco;
    }
            
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }
    
    public function getAll() {
        $sql = "select * from bloco order by nome ";
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
        $sql = "select * from bloco where id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }

    static function create($params) {
        $sql = "INSERT INTO bloco (nome) VALUES (?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['nome']));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id) {
        $sql = 'DELETE FROM bloco WHERE id = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function update($params) {
        $sql = "UPDATE bloco set nome = ? WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['nome'], $this->id));
        return $stmt->errorInfo();
    }


    
}
