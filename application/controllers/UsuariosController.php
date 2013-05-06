<?php

class UsuariosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        // comentario
    }

    public function indexAction()
    {
        $usuarioModel = new Application_Model_Usuario();
        $this->view->usuario = $usuarioModel->selectAll();
        $this->view->usuariocontatos = $usuarioModel->selectAllcontatos();
    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Usuarios();
        $form->startform();
        $model = new Application_Model_Usuario;
        $modelPermissoes= New Application_Model_PermissaoUsuario();
        $id = $this->_getParam('usuario_id');
        $this->view->pais = 76;
        $form->getElement("estados_id")->setRegisterInArrayValidator(FALSE);
        $form->getElement("cidade_id")->setRegisterInArrayValidator(FALSE);
        $upload = new Zend_File_Transfer_Adapter_Http();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();

                //copiar permissoes de perfil-usuarios-permissoes a permissoes segundo
                $codigoperfil=$data['usuario']['perfil_id'];
                $passwordcriptografado=md5($data['usuario']['password']);

                //desabilita o atributo verifypassword
                unset($data['usuario']['verifypassword']);
                unset($data['usuario']['ac']);

                if($id){

                    //adicionar novo arquivo e tirar o antigo na lixeira
                    $newdata=$model->verificarMudancasArquivos($data,$id);

                    //quando a opção contato for selecionada
                    if($data['usuario']['tipo_usuario']=='contato')
                    {
                        unset($data['usuario']['perfil_id']);
                        unset($data['usuario']['username']);
                        unset($data['usuario']['password']);
                    }

                    $newdata['usuario']['password']=$passwordcriptografado;
                    // finalmente atualizamos o banco de dados
                    $model->update($newdata, $id);
                }else{

                    if($data['usuario']['icone']!="")
                    {
                        $nome_imagem=$model->getLastInsertedId();
                        $data=$model->editarImagem($nome_imagem,$data);
                    }
                    if($data['usuario']['tipo_usuario']=='contato')
                    {
                        unset($data['usuario']['perfil_id']);
                        unset($data['usuario']['username']);
                        unset($data['usuario']['password']);
                    }
                    $data['usuario']['password']=$passwordcriptografado;
                    $model->insert($data);

                    //obteniendo ID usuario
                    $IDusuario= $modelPermissoes->getLastInsertedId();
                    // adicionamos na tabela "permissao-usuario" as permissoes trazidas desde perfil-permissao segundo o id de usuario e o id do perfil
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $permissoes=$db->fetchAll("SELECT controller, action, valor FROM `perfil-permissao` p where perfil_id=$codigoperfil;");

                    for($i=0;$i<count($permissoes); $i++)
                    {
                        $datapermissoes['usuario_id']=$IDusuario;
                        $datapermissoes['controller']=$permissoes[$i]['controller'];
                        $datapermissoes['action']=$permissoes[$i]['action'];
                        $datapermissoes['valor']=$permissoes[$i]['valor'];
                        $modelPermissoes->insert($datapermissoes);
                    }
                    $this->_redirect('/usuarios/treeviewpermissoes/usuario_id/'.$IDusuario);
                }
                $this->_redirect('/usuarios/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();
            $this->view->pais = $data['pais_id'];

            if(is_array($data)){
                $idinstituicao=$data['instituicao_id'];
                $idestado=$data['estados_id'];
                $idcidade=$data['cidade_id'];
                $form->setAction('/usuarios/detalhes/usuario_id/' . $id);
                $form->setIdCidade($idcidade);
                $form->setIdEstado($idestado);
                $form->startform();
                $db = Zend_Db_Table::getDefaultAdapter();
                $nome_instituicao=$db->fetchRow("select nome from instituicao where instituicao_id=$idinstituicao");

                $data['ac']=$nome_instituicao['nome'];
                $form->populate(array("usuario" => $data));
            }
        }

        $this->view->form = $form;
    }

    public function adicionarcontatosAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Usuarios_Contatos();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');
        $this->view->pais = 76;
        $form->getElement("estados_id")->setRegisterInArrayValidator(FALSE);
        $form->getElement("cidade_id")->setRegisterInArrayValidator(FALSE);
        $upload = new Zend_File_Transfer_Adapter_Http();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();

                //desabilita o atributo verifypassword
                unset($data['usuario']['verifypassword']);

                if($id){
                    //adicionar novo arquivo e tirar o antigo na lixeira
                    $newdata=$model->verificarMudancasArquivos($data,$id);
                    // finalmente atualizamos o banco de dados
                    $model->update($newdata, $id);
                }else{
                    if($data['usuario']['icone']!="")
                    {
                        $nome_imagem=$model->getLastInsertedId();
                        $data=$model->editarImagem($nome_imagem,$data);
                    }

                    $model->insert($data);
                }
                $this->_redirect('/usuarios/');
            }
        }elseif  ($id){

            $data = $model->find($id)->toArray();
            $this->view->pais = $data['pais_id'];

            if(is_array($data)){
                $form->setAction('/usuarios/detalhescontatos/usuario_id/' . $id);
                $form->populate(array("usuario" => $data));
            }
        }

        $this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Usuarios();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');
        $this->view->id = $id;
        $db = Zend_Db_Table::getDefaultAdapter();

        $data = $model->find($id)->toArray();
        $detalhes->startform();
        $id_instituicao=$data['instituicao_id'];
        $nome_instituicao=$db->fetchRow("select nome from instituicao where instituicao_id=$id_instituicao");
        $data['ac']=$nome_instituicao['nome'];

        if(is_array($data)){
            $detalhes->setAction('/usuarios/detalhes/usuario_id/' . $id);
            $detalhes->populate(array("usuario" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    public function detalhescontatosAction(){
        $request = $this->getRequest();
        $detalhes =new Application_Form_Usuarios_Contatos();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');
        $this->view->id = $id;

        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/usuarios/detalhescontatos/usuario_id/' . $id);
            $detalhes->populate(array("usuario" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Usuarios();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');

        $model->delete($id);

        $this->_redirect('/usuarios/');

        $this->view->excluir = $excluir;
    }

    public function excluircontatosAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Usuarios_Contatos();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');

        $model->delete($id);

        $this->_redirect('/usuarios/');

        $this->view->excluir = $excluir;
    }

    public function selectestadosAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id', 0)) {
            $id = (int) $this->_request->getParam('id', 0);
            $filhos = new Application_Model_DbTable_Estados();
            $rows = $filhos->fetchAll('pais_id = ' . (int) $id);
            echo '<option value="">Selecione</option>';
            foreach ($rows as $row) {
                echo '<option value="' . $row->estados_id . '">' . $row->estados_nome . '</option>';
            }
        } else {
            echo '<option value="">Selecione</option>';
        }
    }

    public function selectcidadesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

         if ($this->_request->getParam('id', 0)) {
            $id = (int) $this->_request->getParam('id', 0);
            $filhos = new Application_Model_DbTable_Cidade();
            $rows = $filhos->fetchAll('estados_id = ' . (int) $id);
            echo '<option value="">Selecione</option>';
            foreach ($rows as $row) {
                echo '<option value="' . $row->cidade_id . '">' . $row->cidade_nome . '</option>';
            }
        } else {
            echo '<option value="">Selecione</option>';
        }

    }

    public function treeviewAction()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('iframe');
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('instituicao_id');
        if($id==null)
        {
            $id=32;
        }
        // mostra as instituições pais
        $this->view->tree = $model->retornaPais();

        // retorna array do procedure
        $result=$model->paeFilhos($id);

        // cria o treeview
        $model->criarTreeview($result);

        $this->view->treeview;
    }

    public function treeviewpermissoesAction()
    {
        $modelpermissões = new Application_Model_PermissaoUsuario();
        $id_usuario = $this->_getParam('usuario_id');
        $this->view->usuario_id=$id_usuario;


        if($this->getRequest()->isPost())
        {
            $datos=$this->getRequest()->getParams();
            $datostreeview=$datos['datostree'];
            $modelpermissões->delete($id_usuario);


            foreach($datostreeview as $item)
            {
                if($item=='usuarios|detalhes|*')
                {
                    $data['usuario_id']=$id_usuario;
                    $dataexplode=explode('|',$item);
                    $data['controller']=$dataexplode[0];
                    $data['action']='detalhescontatos';
                    $data['valor']=$dataexplode[2];
                    $modelpermissões->insert($data);
                }

                $data['usuario_id']=$id_usuario;
                $dataexplode=explode('|',$item);
                $data['controller']=$dataexplode[0];
                $data['action']=$dataexplode[1];
                $data['valor']=$dataexplode[2];


                $modelpermissões->insert($data);
            }
            $this->_redirect('/usuarios/');
        }else
        {
            //verificamos se o usuario é novinho ou já é um usuario registrado, por o numeros de projeto cadastrado
            $db = Zend_Db_Table::getDefaultAdapter();
            $result = $db->fetchAll("SELECT controller, action, valor FROM `permissao-usuario` WHERE usuario_id=$id_usuario");
            $nomeprojeto= $db->fetchAll("SELECT distinct PU.valor, P.nome FROM `permissao-usuario` as PU inner join projeto as P on PU.valor=P.projeto_id where PU.usuario_id=$id_usuario ");

            $permissoes=null;
            //concatenamos os valores da consulta
            for($i=0;$i<count($result);$i++)
            {
                $permissoes[$i]=$result[$i]['controller'].'|'.$result[$i]['action'].'|'.$result[$i]['valor'];
            }

            $this->view->permissoes=$permissoes;
            $this->view->nomeprojetos=$nomeprojeto;
            //huihui
        }
    }

    public function fancyboxprojetosAction()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('iframe');
        $model = new Application_Model_Usuario;

        $this->view->fancy=$model->selectAllProjects();
    }
}
