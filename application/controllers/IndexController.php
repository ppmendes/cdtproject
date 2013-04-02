<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    /* Initialize action controller here */
        $layout = $this->_helper->layout();
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $layout->setLayout('login');
        }
    }

    public function indexAction()
    {

        $request = $this->getRequest();
        $form = new Application_Form_Index();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                $this->login($data['username'],$data['password']);
            }
        }

        $this->view->form = $form;

    }

    private function login($username,$password){

        /* Resgata o adaptador do banco de dados utilizado */
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $authAdapter = new Zend_Auth_Adapter_DbTable(
            $dbAdapter,
            'usuario',
            'username',
            'password',
            'md5(?) AND deletado = 0');

        /* Estou pressupondo que o login e senha foram capturados nas variáveis
        $username e $password */
        $authAdapter->setIdentity($username)->setCredential($password);
        /* Variável que guarda o resultado da tentativa de autenticação */
        $result = $authAdapter->authenticate();
        /* Agora verificamos se o retorno de $result é verdadeiro ou falso */
        if ($result->isValid()) {
            /* Se verdadeiro inicia uma instância do Zend Auth */
            $auth = Zend_Auth::getInstance();
            /* Resgata os dados do usuário, exceto a coluna senha */
            $data = $authAdapter->getResultRowObject(null, 'password');

            //TODO pegar id do usuário e buscar as permissões
            $db = Zend_Db_Table::getDefaultAdapter();

            //array com as permissões do usuário
            $permissoesdb = $db->fetchAll("select controller, action, valor FROM `permissao-usuario` where usuario_id=$data->usuario_id;");

            $permissoes = array();
            foreach($permissoesdb as $permissao){
                    $permissoes[$permissao['controller']][$permissao['action']][$permissao['valor']] = true;
            }

            $data->permissoes = $permissoes;

            /* Grava a seção no sistema */
            $auth->getStorage()->write($data);
            /* Uma vez que o usuário está logado você pode optar por redirecioná-lo ou
            exibir alguma mensagem */
            $this->_redirect("/projetos");
        } else {
            /* Caso o usuário não tenha sido autenticado por algum motivo você registra
            aqui que atitude tomar */
            $auth = Zend_Auth::getInstance();
            $auth->clearIdentity();
            echo "ERRO";
        }
    }

    public function logoutAction(){
        /* Inicia uma instância de Zend Auth */
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect("/");
    }

    public function permissiondeniedAction(){

    }


}

