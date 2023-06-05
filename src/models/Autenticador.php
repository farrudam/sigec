<?php

namespace sigec\models;

use sigec\models\UsuarioLDAP;
use sigec\models\LDAP;
//use sigec\models\Setor;
use sigec\models\Usuario;

abstract class Autenticador {

    private static $instancia = null;

    private function __construct() {
        
    }

    /**
     * 
     * @return Autenticador
     */
    public static function instanciar() {

        if (self::$instancia == NULL) {
            self::$instancia = new AutenticadorEmMemoria();
        }

        return self::$instancia;
    }

    public abstract function logar($login, $senha, $tp);

    public abstract function logado();

    public abstract function encerraSessao();

    public abstract function getUsuarioNome();

    public abstract function expulsar($app, $rota);

    public abstract function pegar_privilegio();

    public abstract function getMatricula();

    public abstract function getUsuarioRol();

    public abstract function confereSenhas($senha);
    
    public abstract function getSenha();
}

class AutenticadorEmMemoria extends Autenticador {

    public function logado() {
        $sess = new Sessao();
        return $sess->existe('nome');
    }

    public function logar($login, $senha, $tp) {
        $sess = new Sessao();
        $sess->instanciar();

        if ($tp == 'SUAP') {        
            $ldap = new LDAP();
            $usuario = $ldap->buscar_usuario($login, $senha);
            
            if (!$usuario)
                return false;
            
            //Setor::create($usuario->getDepartment(), $usuario->getDepartment(), 1, 1);
           // $setor_id = Setor::getBySigla($usuario->getDepartment())->getSetor_id();
            
            //$msg = Usuario::loginCriarOuAtualizar($usuario->getCn(), $usuario->getDisplayname(), $usuario->getTelephonenumber(), $usuario->getMail(), str_shuffle($usuario->getDisplayname().$usuario->getCn()), $setor_id);
            $msg = Usuario::loginCriarOuAtualizar($usuario->getCn(), $usuario->getDisplayname(), $usuario->getTelephonenumber(), $usuario->getMail(), str_shuffle($usuario->getDisplayname().$usuario->getCn()));
            $user = $usuario->getCn();
            $usuario_cad = Usuario::getByLogin($user);
           
            if (!$usuario_cad){
                return false;
            }
        }else{
            $user = $login;
            $usuario_cad = (new Usuario())->getByMatricula($user);
            if (!$usuario_cad){
                return false;
            }
            $crypt_pass = md5($senha);
            //$crypt_pass = password_hash($senha, PASSWORD_DEFAULT);
            if ($crypt_pass != $usuario_cad->getSenha())
                return false;
        }
        
        $sess->set('nome', $usuario_cad->getNome());
        $sess->set('perfil', $usuario_cad->getPerfil());
        $sess->set('matricula', $user);
        $sess->set('pwd', '');
        return true;
        
    }
  public function getSenha() {
        $sess = new Sessao();

        if ($this->logado()) {
            $pwd = $sess->get('pwd');
            return $pwd;
        } else {
            return false;
        }
    }
    public function getUsuarioRol() {
        $sess = new Sessao();

        if ($this->logado()) {
            $usuario = $sess->get('privilegio');
            return $usuario;
        } else {
            return false;
        }
    }

    public function confereSenhas($senha) {
        $sess = new Sessao();

        if ($this->logado()) {
            return $sess->get('pwd') == md5($senha);
            //return password_verify($senha, $sess->get('pwd'));
        } else {
            return false;
        }
    }

    public function getUsuarioNome() {
        $sess = new Sessao();

        if ($this->logado()) {
            $usuario = $sess->get('nome');
            return $usuario;
        } else {
            return false;
        }
    }

    function getMatricula() {
        $sess = new Sessao();

        if ($this->logado()) {
            $usuario = $sess->get('matricula');
            return $usuario;
        } else {
            return false;
        }
    }

    public function pegar_privilegio() {
        $sess = new Sessao();

        if ($this->logado()) {
            $usuario = $sess->get('privilegio');
            return $usuario;
        } else {
            return false;
        }
    }

    public function expulsar($app, $rota) {

        $app->redirect($rota);
    }

    public function encerraSessao() {
        // Inicializa a sessão.
        // Se estiver sendo usado session_name("something"), não esqueça de usá-lo agora!
        //session_start();
        // Apaga todas as variáveis da sessão
        $_SESSION = array();

        // Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
        // Nota: Isto destruirá a sessão, e não apenas os dados!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 403000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }

        // Por último, destrói a sessão
        
        session_destroy();
    }

}

?>