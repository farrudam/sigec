<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Bloco;

class Sala{

    private $id;
    private $nome;
    private $id_bloco;
    private $situacao;
    
    private $bloco;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    private function bundle ($row){        
             
        $sala = new Sala($row['id']);
        $bloco = new Bloco($row['id_bloco']);

        $sala->setNome($row['nome']);                
        $sala->setBloco($bloco->getById('id_bloco'));
        $sala->setSituacao($row['situacao']);
        $sala->setIdBloco($row['id_bloco']);  
    
        return $sala;
    }
    
    public function getAll() {
        $sql = "select * from sala order by id ";
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
        $sql = "select * from sala where id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }

    static function create($params) {
        $sql = "INSERT INTO sala (id_bloco, nome) VALUES (?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['id_bloco'],  
            $params['nome']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id) {
        $sql = 'DELETE FROM sala WHERE id = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function update($params) {
        $sql = "UPDATE sala set nome = ? WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['nome'], $this->id));
        return $stmt->errorInfo();
    }

    static function ativar($id) {
        $sql = "UPDATE sala set situacao = 'ativa' WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    static function desativar($id) {
        $sql = "UPDATE sala set situacao = 'inativa' WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    static function reparar($id) {
        $sql = "UPDATE sala set situacao = 'manutencao' WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function getIdBloco() {
        return $this->id_bloco;
    }

    public function getBloco() {
        return $this->bloco;
    }    

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setSituacao($situacao): void {
        $this->situacao = $situacao;
    }

    public function setIdBloco($id_bloco) {
        $this->id_bloco = $id_bloco;
    } 

    public function setBloco($bloco) {
        $this->bloco = $bloco;
    }
    
}