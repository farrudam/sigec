<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Sala;
use sigec\models\RestricaoChave;

class Chave{

    private $id;
    private $etiqueta;
    private $descricao;
    private $situacao;
    private $habilitada;    
    private $restrita;        

    private $id_sala;
    private $sala;
    
    private $restricoes = [];
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    private function bundle ($row){        
        
        $chave = new Chave($row['id']);        
        
        $sala = new Sala($row['id_sala']);
        

        $chave->setEtiqueta($row['etiqueta']);                
        $chave->setDescricao($row['descricao']);
        $chave->setSituacao($row['situacao']);
        $chave->setHabilitada($row['habilitada']);
        $chave->setRestrita($row['restrita']);
                        
        $chave->setSala($sala->getById());
        $chave->setIdSala($row['id_sala']);
        
        $chave->setRestricoes($row['restricoes']);
    
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
        $sql = "INSERT INTO chave (id_sala, etiqueta, descricao) VALUES (?, ?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(              
            $params['id_sala'],  
            $params['etiqueta'],
            $params['descricao']
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
        $sql = "UPDATE chave set descricao = ?, etiqueta = ? WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['descricao'], $params['etiqueta'], $this->id));
        return $stmt->errorInfo();
    }

    static function habilitar($id) {
        $sql = "UPDATE chave set habilitada = 1 WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    static function desabilitar($id) {
        $sql = "UPDATE chave set habilitada = 0 WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }
    
    static function emprestar($id) {
        $sql = "UPDATE chave SET situacao = 'Emprestada' WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }
    
    static function devolver($id) {
        $sql = "UPDATE chave set situacao = 'Disponivel' WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }
    
    static function devolverChaves($id_emprestimo) {
        $sql = "UPDATE chave 
                set situacao = 'Disponivel' 
                WHERE id IN (
                    SELECT id_chave
                    FROM item_emprestimo
                    WHERE id_emprestimo = ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_emprestimo));
        return $stmt->errorInfo();
    }
    
    public function getRestricoes() {
        if (empty($this->restricoes)){
            $this->restricoes = RestricaoChave::getRestricoesByChave($this->id);
        }
        return $this->chaves;
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

    public function getRestrita() {
        return $this->restrita;
    }

    public function getIdSala() {
        return $this->id_sala;
    }

    public function getSala() {
        return $this->sala;
    }  
    
    public function setRestricoes($restricoes) {
        $this->restricoes = $restricoes;
    }

    public function setId($id): void {
        $this->id = $id;
    }    

    public function setEtiqueta($etiqueta) {
        $this->etiqueta = $etiqueta;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function setHabilitada($habilitada) {
        $this->habilitada = $habilitada;
    }

    public function setRestrita($restrita) {
        $this->restrita = $restrita;
    }

    public function setIdSala($id_sala) {
        $this->id_sala = $id_sala;
    }

    public function setSala($sala) {
        $this->sala = $sala;
    }
    
}