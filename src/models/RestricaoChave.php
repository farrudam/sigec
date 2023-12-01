<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Chave;
use sigec\models\Usuario;

class RestricaoChave{
                
    private $id_chave;
    private $chave;
    
    private $mat_solic;
    private $mat_user_inclusao;
    private $mat_user_remocao;
    
    private $usuario;
    private $user_inclusao;
    private $user_remocao;
    
    private $data_inclusao; 
    private $data_remocao;     
    
    private $motivo_inclusao;
    private $ativa; 
    
    public function __construct($id_chave = null) {        
        $this->id_chave = $id_chave;        
    }
    
    private function bundle ($row){  
        //Instâncias dos objetos
             
        $chave =  (new Chave())->getById($row['id_chave']);        
        $usuario = (new Usuario())->getByMatricula($row['mat_solic']);       
        $user_inclusao = (new Usuario())->getByMatricula($row['user_inclusao']);
        $user_remocao = (new Usuario())->getByMatricula($row['user_remocao']);
        
        $restricao_chave = new RestricaoChave($row['id_chave']);
        
        $restricao_chave->setChave($chave);
        $restricao_chave->setUsuario($usuario);
        $restricao_chave->setUserInclusao($user_inclusao);
        $restricao_chave->setUserRemocao($user_remocao);
        
        $restricao_chave->setIdChave($row['id_chave']);
        $restricao_chave->setMatriculaUsuario($row['mat_solic']);
        $restricao_chave->setMatUserInclusao($row['user_inclusao']);
        $restricao_chave->setMatUserRemocao($row['user_remocao']); 
                
        $restricao_chave->setDataInclusao($row['data_inclusao']);
        $restricao_chave->setDataRemocao($row['data_remocao']);        
        
        $restricao_chave->setMotivo($row['motivo_inclusao']);
        $restricao_chave->setAtiva($row['ativa']); 
                        
        return $restricao_chave;
    }  
    
    static function create($params) {

        $sql = "INSERT INTO restricao_chave (id_chave, mat_solic, user_inclusao, motivo_inclusao) VALUES (?, ?, ?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['chave'],  
            $params['matricula'],
            $params['user_inclusao'],
            $params['justificativa']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($user_remocao, $id_chave, $mat_solic, $data_inclusao) {        
  
        $sql =   "UPDATE restricao_chave "
                . "SET data_remocao = CURRENT_TIME(), user_remocao = ?, ativa = '0' "
                . "WHERE restricao_chave.id_chave = ? AND restricao_chave.mat_solic = ? AND restricao_chave.data_inclusao = ?";       
                
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($user_remocao, $id_chave, $mat_solic, $data_inclusao)); 
        
        return $stmt->errorInfo();
    }    
    
    public function getAll() {
        $sql = "select * from restricao_chave";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result;
    }
    
//    public static function habilitarTodos($idChave) {
//        $sql = "UPDATE restricao_chave SET data_remocao = CURRENT_TIME(), user_remocao = ?, ativa = '0' WHERE id_chave = ?";
//        $stmt = DBSigec::getKeys()->prepare($sql);
//        $stmt->execute([Autenticador::instanciar()->getMatricula(), $idChave]);
//    }
//    
//    public static function restringirTodos($idChave) {
//        $sql = "UPDATE restricao_chave SET data_inclusao = CURRENT_TIME(), user_inclusao = ?, ativa = '1' WHERE id_chave = ?";
//        $stmt = DBSigec::getKeys()->prepare($sql);
//        $stmt->execute([Autenticador::instanciar()->getMatricula(), $idChave]);
//    }
        
    static function getRestricoesByChave($id_chave) {
        $sql = "select * from restricao_chave where id_chave = ? and ativa = 1";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_chave));
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = self::bundle($row);
        }
        return $result;
    }  
    
    static function getRestricoesByUser($mat_solic) {        
        $sql = "SELECT id_chave FROM restricao_chave WHERE mat_solic = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($mat_solic));
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row['id_chave']; // Adicionando apenas o ID da chave ao resultado
        }
        return $result;
        }
    
    static function getRestricaoAtiva($id_chave, $mat_solic) {
        $sql = "select * from restricao_chave where id_chave = ? AND mat_solic = ? AND ativa = 1";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id_chave, $mat_solic));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }     
    
    public function buscarChavesRestritas($mat_solic)
    {   
        
        $sql = "SELECT id_chave FROM restricao_chave WHERE mat_solic = ? AND ativa = 1";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($mat_solic));
        $rows = $stmt->fetchAll();
        $chavesRestritas = [];
        foreach ($rows as $row) {
            $chavesRestritas[] = $row['id_chave'];
        }
        return $chavesRestritas;
        
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

    public function getMatriculaUsuario() {
        return $this->mat_solic;
    }  
    
    public function getUserInclusao() {
        return $this->user_inclusao;
    } 

    public function getMatUserInclusao() {
        return $this->mat_user_inclusao;
    } 
    
    public function getUserRemocao() {
        return $this->user_remocao;
    } 

    public function getMatUserRemocao() {
        return $this->mat_user_remocao;
    } 
    
    public function getDataInclusao() {
        return $this->data_inclusao;
    }
    
    public function getDataRemocao() {
        return $this->data_remocao;
    }
    
    public function getMotivo() {
        return $this->motivo_inclusao;
    }
    
    public function getAtiva() {
        return $this->ativa;
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

    public function setMatriculaUsuario($mat_solic) {
        $this->mat_solic = $mat_solic;
    }
    
    public function setUserInclusao($user_inclusao) {
        $this->user_inclusao = $user_inclusao;
    }

    public function setMatUserInclusao($mat_user_inclusao) {
        $this->mat_user_inclusao = $mat_user_inclusao;
    }
    
    public function setUserRemocao($user_remocao) {
        $this->user_remocao = $user_remocao;
    }

    public function setMatUserRemocao($mat_user_remocao) {
        $this->mat_user_remocao = $mat_user_remocao;
    }
    
    public function setDataInclusao($data_inclusao) {
        $this->data_inclusao = $data_inclusao;
    }
    
    public function setDataRemocao($data_remocao) {
        $this->data_remocao = $data_remocao;
    }
    
    public function setMotivo($motivo_inclusao) {
        $this->motivo_inclusao = $motivo_inclusao;
    }
    
    public function setAtiva($ativa) {
        $this->ativa = $ativa;
    }
    
    
}