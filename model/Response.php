<?php 

class Response{
    private $_Success;
    private $_httpStatusCode;
    private $_message = array();
    private $_toCache;
    private $_responseData = array();

    public function setSuccess($success){
        $this->_Success = $success;
    }

    public function setHttpStatusCode($httpStatusCode){
        $this->_httpStatusCode = $httpStatusCode;
    }

    public function setMessage($message){
        $this->_message[] = $message;
    }

    public function setCache($Cache){
        $this->_toCache = $Cache;
    }

    public function Send(){
        header('Content-type: application/json;charset:utf-8');
        if($this->_toCache == true){
            header('Cache-control: max-age=60');
        }else{
            header('Cache-control: no cache, no store');
        }

        if(($this->_Success !== false && $this->_Success !== true) || !is_numeric($this->_httpStatusCode)){
            http_response_code(500);
            $this->_responseData['statusCode'] = 500;
            $this->_responseData['success'] = false;
            $this->setMessage('Response Server Error');
            $this->_responseData['message'] = $this->_message;
        }else{
            http_response_code($this->_httpStatusCode);
            $this->_responseData['statusCode'] = $this->_httpStatusCode;
            $this->_responseData['success'] = $this->_Success;
            $this->_responseData['message'] = $this->_message;
        }
        echo json_encode($this->_responseData);
    }
}