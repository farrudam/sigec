<?php

namespace sigec\models;
use sigec\database\DBSigec;

class Usuario{
    
    private $id;
    private $matricula;
    private $nome;
    private $senha;
    private $celular;
    private $email;
    private $url_foto;
    private $habilitado;
    private $doc_autorizacao;
    private $tipo;
    private $perfil;
    
    public function __construct($id = null) {
        $this->id = $id;        
    }
    
    private function bundle ($row){
        $usuario = new Usuario($row['id']);
        $usuario->setMatricula($row['matricula']);
        $usuario->setNome($row['nome']);
        $usuario->setSenha($row['senha']);
        $usuario->setCelular($row['celular']);
        $usuario->setEmail($row['email']);
        $usuario->setUrl_foto($row['url_foto']);
        $usuario->setHabilitado($row['habilitado']);
        $usuario->setDoc_autorizacao($row['doc_autorizacao']);
        $usuario->setTipo($row['tipo']);
        $usuario->setPerfil($row['perfil']);        
        
        return $usuario;
    }
    
    public function getByMatricula($matricula) {
        $sql = "select * from usuario where matricula = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($matricula));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }
    
    public function getAll() {
        $sql = "select * from usuario order by id ";
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
        $sql = "select * from usuario where id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }
    

    static function create($params) {        
        $sql = "INSERT INTO usuario (matricula, nome, senha, celular, email, tipo, perfil) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['matricula'],
            $params['nome'],
            $params['senha'],
            $params['celular'],
            $params['email'],
            $params['tipo'],
            $params['perfil']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id) {
        $sql = 'DELETE FROM usuario WHERE id = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function update($params) {
        $sql = "UPDATE usuario set nome = ?, email = ?, celular = ?, perfil = ?, 
                       doc_autorizacao = ?, url_foto = ? WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['nome'],
            $params['email'],            
            $params['celular'],            
            $params['perfil'],            
            $params['doc_autorizacao'],
            $params['url_foto'],
             $this->id));
        return $stmt->errorInfo();
    }

    static function ativar($id) {
        $sql = "UPDATE usuario set habilitado = 1 WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    static function desativar($id) {
        $sql = "UPDATE usuario set habilitado = 0 WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }
    
    static function buscar($busca) {
        $sql = "SELECT * FROM usuario WHERE matricula LIKE '%$busca%'";        
        //$sql = "SELECT * FROM usuario WHERE matricula = '%$busca'";        
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($busca));
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result; 
    }
    
    static function pesquisar($busca) {
        $sql = "SELECT matricula FROM usuario WHERE matricula LIKE '%$busca%'";        
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($busca));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row); 
    }

    
    public function getId() {
        return $this->id;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUrl_foto() {
        return $this->url_foto;
    }

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function getDoc_autorizacao() {
        return $this->doc_autorizacao;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getPerfil() {
        return $this->perfil;
    }   

    public function setId($id): void {
        $this->id = $id;
    }

    public function setMatricula($matricula): void {
        $this->matricula = $matricula;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }
    
    public function setCelular($celular): void {
        $this->celular = $celular;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setUrl_foto($url_foto): void {
        $this->url_foto = $url_foto;
    }

    public function setHabilitado($habilitado): void {
        $this->habilitado = $habilitado;
    }

    public function setDoc_autorizacao($doc_autorizacao): void {
        $this->doc_autorizacao = $doc_autorizacao;
    }

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function setPerfil($perfil): void {
        $this->perfil = $perfil;
    }
    
}