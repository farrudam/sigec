<?php

namespace sigec\models;
use sigec\database\DBSigec;

class Usuario{
    
    private $matricula;
    private $nome;
    private $senha;
    private $telefone;
    private $email;
    private $url_foto;
    private $habilitado;
    private $doc_autorizacao;
    private $tipo;
    private $permissao;
    
    public function __construct($matricula = null) {
        $this->matricula = $matricula;
    }
    
    private function bundle ($row){
        $usuario = new Usuario($row['matricula']);
        $usuario->setNome($row['nome']);
        $usuario->setSenha($row['senha']);
        $usuario->setTelefone($row['telefone']);
        $usuario->setEmail($row['email']);
        $usuario->setUrl_foto($row['url_foto']);
        $usuario->setHabilitado($row['habilitado']);
        $usuario->setDoc_autorizacao($row['doc_autorizacao']);
        $usuario->setTipo($row['tipo']);
        $usuario->setPermissao($row['permissao']);        
        
        return $usuario;
    }           
    
    public function getAll() {
        $sql = "select * from usuario order by nome ";
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
        $sql = "select * from usuario where matricula = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->matricula));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }

    static function create($params) {
        $sql = "INSERT INTO usuario (nome) VALUES (?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['nome']));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($matricula) {
        $sql = 'DELETE FROM usuario WHERE matricula = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($matricula));
        return $stmt->errorInfo();
    }

    public function update($params) {
        $sql = "UPDATE usuario set nome = ? WHERE matricula = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['nome'], $this->matricula));
        return $stmt->errorInfo();
    }

    static function ativar($matricula) {
        $sql = "UPDATE usuario set habilitado = 1 WHERE matricula = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($matricula));
        return $stmt->errorInfo();
    }

    static function desativar($matricula) {
        $sql = "UPDATE usuario set habilitado = 0 WHERE matricula = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($matricula));
        return $stmt->errorInfo();
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

    public function getTelefone() {
        return $this->telefone;
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

    public function getPermissao() {
        return $this->permissao;
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
    
    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
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

    public function setPermissao($permissao): void {
        $this->permissao = $permissao;
    }
    
}
