<?php
namespace sigec\models;

use sigec\models\UsuarioLDAP;

/* 
$ldapusercheck = 'consultor';
$ldappasscheck = 'aH7fCXY8j2Zjo2sCRCqBy8IGWEocjm';
$ldaptree = 'OU=IFCE,DC=ad,DC=ifce,DC=tia';
$ldapserver = 'srv-dc.ad.ifce.tia';
*/
class LDAP { 
    private $ldapserver = 'ad.ifce.edu.br';
    private $ldapusercheck = 'bind@check!pass';
    private $ldappasscheck = 'vpnbind@ad.ifce.edu.br';
    private $ldaptree = 'DC=ad,DC=ifce,DC=edu,DC=br';

//if (isset($_POST['usuario']) and isset($_POST['senhaatual']) and isset($_POST['novasenha']) and isset($_POST['repetesenha'])) {
//    if (!empty($_POST['usuario']) and ! empty($_POST['senhaatual']) and ! empty($_POST['novasenha']) and ! empty($_POST['novasenha'])) {
//        $usuariopost = utf8_encode($_POST['usuario']);
//        $senhaatualpost = utf8_encode($_POST['senhaatual']);
//        $novasenhapost = utf8_encode($_POST['novasenha']);
//        $repetenovasenhapost = utf8_encode($_POST['repetesenha']);
//
//        if ($novasenhapost === $repetenovasenhapost) {
//            $usuario = buscar_usuario($usuariopost, $senhaatualpost);
//            if (isset($usuario)) {
//                //echo "<pre>";
//                //print_r($usuario);
//                //echo "</pre>";
//                if (trocarSenha($usuariopost, $novasenhapost)){
//                    echo "Senha alterada com sucesso!";
//                }
//            } else {
//                echo "Usuário ou senha inválida!";
//            }
//        } else {
//                echo "Senha não são iguais";
//            }
//    }
//}

    function trocarSenha($usuarioad, $novasenha) {
        return shell_exec('sudo /srv/AD/ldap.sh '.$usuarioad.' '.$novasenha);
    }

    function conexaoldap() {
        // connect to ldap server
       
        $ldapconn = ldap_connect($this->ldapserver) or die("Could not connect to LDAP server.");

        if ($ldapconn) {
            //echo "conexaoldap() = ok<br>";
            return $ldapconn;
        }
    }

    function buscar_usuario($usuariodca, $senha) {
        $ldapconn = $this->conexaoldap();
        if ($ldapconn) {
            // binding to ldap server
            $ldapbind = ldap_bind($ldapconn, "ad\\" . $usuariodca, $senha) or die("Erro na busca: " . ldap_error($ldapconn));
            // verify binding
            if ($ldapbind) {
               
                //$usuariodca = "douglas.ferreira";
                $filter = "(samaccountname=" . $usuariodca . ")";
                $result = ldap_search($ldapconn, $this->ldaptree, $filter); // or die("Error in search query: " . ldap_error($ldapconn));
                //$usuariodca = ldap_get_entries($ldapconn, $result);
                $entry = ldap_first_entry($ldapconn, $result);
                $usuariodca = ldap_get_attributes($ldapconn, $entry);

                ldap_unbind($ldapbind);
                return $this->setar_usuario($usuariodca);
               
                //return $usuariodca;
            }
            ldap_close($ldapconn);
        }
    }

    function setar_usuario($usuariodca) {
        $usuario = new UsuarioLDAP();
        $usuario->setCn($usuariodca["cn"][0]);
        $usuario->setSn($usuariodca["sn"][0]);
        $usuario->setGivenname($usuariodca["givenName"][0]);
        $usuario->setWhencreated($usuariodca["whenCreated"][0]);
        $usuario->setDisplayname($usuariodca["displayName"][0]);
        $usuario->setBadpwdcount($usuariodca["badPwdCount"][0]);
        $usuario->setBadpasswordtime($usuariodca["badPasswordTime"][0]);
        $usuario->setLastlogoff($usuariodca["lastLogoff"][0]);
        $usuario->setLastlogon($usuariodca["lastLogon"][0]);
        $usuario->setLogoncount($usuariodca["logonCount"][0]);
        $usuario->setSamaccountname($usuariodca["sAMAccountName"][0]);
        $usuario->setPwdlastset($usuariodca["pwdLastSet"][0]);
        $usuario->setMemberof($usuariodca["memberOf"][0]);
        $usuario->setMail($usuariodca["mail"][0]);
        $usuario->setTitle($usuariodca["title"][0]);
        $usuario->setDepartment($usuariodca["department"][0]);
        $usuario->setTelephonenumber($usuariodca["telephoneNumber"][0]);
        $usuario->setDescription($usuariodca["description"][0]);
        $usuario->setWhenchanged($usuariodca["whenChanged"][0]);
        $usuario->setDn($usuariodca["distinguishedName"][0]);
        return $usuario;
        //print_r($usuario);
    }
}
/*
echo '<pre>';
die(print_r(buscar_usuario($usuariodca, $senha)));
echo '</pre>';
*/