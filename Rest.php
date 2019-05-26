<?php


class Rest
{

    public $contentType = "application/json";
    public $requisicao = array();

    private $statusCode = 200;

    public function __construct(){
        $this->inputs();
    }

    public function getReferer(){
        return $_SERVER['HTTP_REFERER'];
    }

    public function response($data,$status){
        $this->statusCode = ($status) ? $status : 200;
        //$this->setHeaders();
        echo $data;
        //exit;
    }

    private function getStatusMessage(){
        $status = array(
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            404 => 'Not Found',
            406 => 'Not Acceptable');
        return ($status[$this->statusCode]) ? $status[$this->statusCode] : $status[500];
    }

    public function getRequestMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    private function inputs(){
        switch ($this->getRequestMethod()) {
            case "POST":
                $this->requisicao = $this->limparCampos($_POST);
                break;
            case "GET":
            case "DELETE":
                $this->requisicao = $this->limparCampos($_GET);
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"),$this->requisicao);
                $this->requisicao = $this->limparCampos($this->requisicao);
                break;
            default:
                $this->response('',406);
                break;
        }
    }

    private function limparCampos($data){
        $limparCampos = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $limparCampos[$k] = $this->limparCampos($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $limparCampos = trim($data);
        }
        return $limparCampos;
    }

    private function setHeaders(){
        header("HTTP/1.1 ".$this->statusCode." ".$this->getStatusMessage());
        header("Content-Type:".$this->contentType);
    }
}
