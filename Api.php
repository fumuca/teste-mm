<?php

require_once("Rest.php");
require_once("AgendaTelefonicaDAO.php");

class Api extends Rest
{

    public $data = "";
    private $agendaTelefonicaDAO;

    /**
     * Api constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->agendaTelefonicaDAO = new AgendaTelefonicaDAO();
    }

    public function processaApi(){

        $func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));

        if ((int)method_exists($this,$func) > 0) {
            return $this->$func();
        } else {
            $this->response('', 404);
        }
    }

    private function contatos(){

        if ($this->getRequestMethod() != "GET") {
            $this->response('',406);
        }
        if (!is_null($this->agendaTelefonicaDAO->getListarContatos())) {
            //$this->response($this->json($this->agendaTelefonicaDAO->getListarContatos()), 200);
            return $this->agendaTelefonicaDAO->getListarContatos();
        }

        $this->response('',204);
    }

    private function contato()
    {
        if ($this->getRequestMethod() != "GET") {
            $this->response('', 406);
        }
        $id = (int)$this->requisicao['id'];

        if ($id > 0) {
            if (!is_null($this->agendaTelefonicaDAO->getListarContatosPorId($id))) {
                //$this->response($this->json($this->agendaTelefonicaDAO->getListarContatosPorId($id)), 200);
                return $this->agendaTelefonicaDAO->getListarContatosPorId($id);
            }
        } else {
            $this->response('', 204);
        }
    }

    private function inserirContato(){

        if ($this->getRequestMethod() != "POST") {
            $this->response('',406);
        }
        $contato = json_decode(file_get_contents("php://input"),true);

        if( is_null($contato) && !empty($_POST['nome']) ) {
            $contato['nome'] = $_POST['nome'];
            $contato['telefone'] = $_POST['telefone'];
            $contato['celular'] = $_POST['celular'];
        }

        if (!empty($contato) && is_array($contato)) {
            $this->agendaTelefonicaDAO->inserir($contato);
            $success = array('status' => "Success", "msg" => "Contato Criado com sucesso!", "data" => $contato);
            $this->response($this->json($success),200);
            //$_REQUEST['x'] = 'contatos';
        } else {
            $this->response('',204);
        }
    }

    private function atualizarContato(){

        if ($this->getRequestMethod() != "POST") {
            $this->response('',406);
        }
        $contato = json_decode(file_get_contents("php://input"),true);

        if( is_null($contato) && !empty($_POST['nome']) ) {
            $contato['nome'] = $_POST['nome'];
            $contato['telefone'] = $_POST['telefone'];
            $contato['celular'] = $_POST['celular'];
            $contato['id'] = $_POST["id"];
        }

        $id = (int)$contato['id'];

        if (!empty($contato)) {
            $this->agendaTelefonicaDAO->atualizar($contato, $id);
            $success = array('status' => "Success", "msg" => "Contato Atualizado com sucesso!", "data" => $contato);
            $this->response($this->json($success), 200);
        } else {
            $this->response('',204);
        }
    }

    private function deletarContato(){
        if ($this->getRequestMethod() != "DELETE") {
            $this->response('',406);
        }
        $id = (int)$this->requisicao['id'];

        if ($id > 0) {
            $this->agendaTelefonicaDAO->apagar($id);
            $success = array('status' => "Success", "msg" => "Contato apagado com sucesso!");
            $this->response($this->json($success),200);
        } else {
            $this->response('', 204);
        }
    }

    private function json($data){
        if (is_array($data)) {
            return json_encode($data);
        }
    }
}

//$api = new Api();
//$rs = $api->processaApi();


