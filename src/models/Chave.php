<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Bloco;
use sigec\models\Sala;

class Chave{

    private $id;
    private $etiqueta;
    private $descricao;
    private $situacao;
    private $habilitada;    

    private $id_bloco;
    private $bloco;

    private $id_sala;
    private $sala;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    private function bundle ($row){        
        
        $chave = new Chave($row['id']);        
        
        $sala = new Sala($row['id']);
        $bloco = new Bloco($row['id_bloco']);

        $sala->setEtiqueta($row['etiqueta']);                
        $sala->setDescricao($row['descricao']);
        $sala->setSituacao($row['situacao']);
        $sala->setHabilitada($row['Habilitada']);
        
        $sala->setBloco($bloco->getById('id_bloco'));
        $sala->setIdBloco($row['id_bloco']); 
        
        $sala->setBloco($bloco->getById('id_bloco'));
        $sala->setIdBloco($row['id_bloco']);
    
        return $chave;
    }
                   
    public function getAll() {
        $sql = "select * from chave order by id ";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result;
    }

    public function getById($id) {
        $sql = "select * from chave where id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }

    static function create($params) {
        $sql = "INSERT INTO chave (id_bloco, id_sala, etiqueta, descricao, situacao, habilitada) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['id_bloco'],  
            $params['id_sala'],  
            $params['etiqueta'],
            $params['descricao'], 
            $params['situacao'],
            $params['habilitada']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id) {
        $sql = 'DELETE FROM chave WHERE id = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function update($params) {
        //$sql = "UPDATE chave set nome = ?, id_bloco = ? WHERE id = ?";
        $sql = "UPDATE chave set descricao = ? WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['descricao'], $this->id));
        return $stmt->errorInfo();
    }

    public function getId() {
        return $this->id;
    }

    public function getEtiqueta() {
        return $this->etiqueta;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function getHabilitada() {
        return $this->habilitada;
    }

    public function getIdBloco() {
        return $this->id_bloco;
    }

    public function getBloco() {
        return $this->bloco;
    }    

    public function getIdSala() {
        return $this->id_sala;
    }

    public function getSala() {
        return $this->sala;
    }  

    public function setId($id): void {
        $this->id = $id;
    }    

    public function setEtiqueta() {
        $this->etiqueta = $etiqueta;
    }

    public function setDescricao() {
        $this->descricao = $descricao;
    }

    public function setSituacao() {
        $this->situacao = $situacao;
    }

    public function setHabilitada() {
        $this->habilitada = $habilitada;
    }

    public function setIdBloco($id_bloco) {
        $this->id_bloco = $id_bloco;
    } 

    public function setBloco($bloco) {
        $this->bloco = $bloco;
    } 
    
    public function setIdSala() {
        $this->id_sala = $id_sala;
    }

    public function setSala() {
        $this->sala = $sala;
    }
    
}