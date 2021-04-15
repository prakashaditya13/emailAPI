<?php

class EmailException extends Exception{}

class Email{
    private $_toEmail;
    private $_subject;
    private $_body;
    private $_fromEmail;

    public function __construct($toEmail, $Sub, $body, $fromEmail)
    {
        $this->setToEmail($toEmail);
        $this->setSubject($Sub);
        $this->setBody($body);
        $this->setFromEmail($fromEmail);
    }

    public function getToEmail(){
        return $this->_toEmail;
    }

    public function getSub(){
        return $this->_subject;
    }

    public function getBody(){
        return $this->_body;
    }

    public function getFromEmail(){
        return $this->_fromEmail;
    }

    public function setToEmail($toEmail){
        if(($toEmail != null) && ($this->_toEmail != null) && (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) && (!filter_var($this->_toEmail, FILTER_VALIDATE_EMAIL))){
            throw new EmailException('Email format Error');
        }
        $this->_toEmail = $toEmail;
    }

    public function setSubject($Sub){
        $this->_subject = $Sub;
    }

    public function setBody($body){
        $this->_body = $body;
    }

    public function setFromEmail($fromEmail){
        if(($fromEmail != null) && ($this->_fromEmail != null) && (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) && (!filter_var($this->_fromEmail, FILTER_VALIDATE_EMAIL))){
            throw new EmailException('Email format Error');
        }
        $this->_fromEmail = $fromEmail;
    }

    // Helper Method

    public function returnEmailAsArray(){
        $email = array();
        $email['toEmail'] = $this->getToEmail();
        $email['sub'] = $this->getSub();
        $email['body'] = $this->getBody();
        $email['fromEmail'] = $this->getFromEmail();
        return $email;
    }
    
}