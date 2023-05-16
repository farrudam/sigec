<?php
namespace sigec\models;

class UsuarioLDAP {
    private $cn; // Nome completo
    private $sn; // Sobrenome
    private $givenname; // Primeiro nome
    private $whencreated; // Data criado - YYYY MM DD HH mm ss.s Z
    private $displayname; //Nome de exibicao
    private $Badpwdcount; //Total de erros de senha
    private $Badpasswordtime; // Data da última tentativa de senha invalida
    private $lastlogoff; // Data do ultimo logoff
    private $lastlogon; // Data do ultimo logon
    private $logoncount; // O número de vezes que a conta efetuou logon com êxito.
    private $samaccountname; // Nome de usuario
    private $pwdlastset; // A data e a hora em que a senha dessa conta foi alterada pela última vez.
    private $memberof; // Grupo membro
    private $mail; // Email
    private $title; // Cargo
    private $department; // Setor
    private $telephonenumber; // Telefone
    private $description; // Campo descricao = Data de aniversario
    private $whenchanged; // Data da ultima alteração no usuario
    private $dn; // DN do usuario
    
    function getCn() {
        return $this->cn;
    }

    function getSn() {
        return $this->sn;
    }

    function getGivenname() {
        return $this->givenname;
    }

    function getWhencreated() {
        return $this->whencreated;
    }

    function getDisplayname() {
        return $this->displayname;
    }

    function getBadpwdcount() {
        return $this->Badpwdcount;
    }

    function getBadpasswordtime() {
        return $this->Badpasswordtime;
    }

    function getLastlogoff() {
        return $this->lastlogoff;
    }

    function getLastlogon() {
        return $this->lastlogon;
    }

    function getLogoncount() {
        return $this->logoncount;
    }

    function getSamaccountname() {
        return $this->samaccountname;
    }

    function getPwdlastset() {
        return $this->pwdlastset;
    }

    function getMemberof() {
        return $this->memberof;
    }

    function getMail() {
        return $this->mail;
    }

    function getTitle() {
        return $this->title;
    }

    function getDepartment() {
        return $this->department;
    }

    function getTelephonenumber() {
        return $this->telephonenumber;
    }

    function getDescription() {
        return $this->description;
    }

    function getWhenchanged() {
        return $this->whenchanged;
    }

    function getDn() {
        return $this->dn;
    }

    function setCn($cn) {
        $this->cn = $cn;
    }

    function setSn($sn) {
        $this->sn = $sn;
    }

    function setGivenname($givenname) {
        $this->givenname = $givenname;
    }

    function setWhencreated($whencreated) {
        $this->whencreated = $whencreated;
    }

    function setDisplayname($displayname) {
        $this->displayname = $displayname;
    }

    function setBadpwdcount($Badpwdcount) {
        $this->Badpwdcount = $Badpwdcount;
    }

    function setBadpasswordtime($Badpasswordtime) {
        $this->Badpasswordtime = $Badpasswordtime;
    }

    function setLastlogoff($lastlogoff) {
        $this->lastlogoff = $lastlogoff;
    }

    function setLastlogon($lastlogon) {
        $this->lastlogon = $lastlogon;
    }

    function setLogoncount($logoncount) {
        $this->logoncount = $logoncount;
    }

    function setSamaccountname($samaccountname) {
        $this->samaccountname = $samaccountname;
    }

    function setPwdlastset($pwdlastset) {
        $this->pwdlastset = $pwdlastset;
    }

    function setMemberof($memberof) {
        $this->memberof = $memberof;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDepartment($department) {
        $this->department = $department;
    }

    function setTelephonenumber($telephonenumber) {
        $this->telephonenumber = $telephonenumber;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setWhenchanged($whenchanged) {
        $this->whenchanged = $whenchanged;
    }

    function setDn($dn) {
        $this->dn = $dn;
    }
}
