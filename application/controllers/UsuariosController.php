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
                unset($data['usuario']['ac']);
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
        }elseif ($id){
            $data = $model->find($id)->toArray();
            $this->view->pais = $data['pais_id'];

            if(is_array($data)){
                $form->setAction('/usuarios/detalhes/usuario_id/' . $id);
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
        }elseif ($id){
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


        $data = $model->find($id)->toArray();

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
        $this->view->tree = $model->retornaPais();

        $result=$model->paeFilhos($id);
        $model->criarTreeview($result);

        $this->view->treeview;
    }

    public function treeAction()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('iframe');
        $model = new Application_Model_Usuario();

        //$model->paeFilhos();
        $model->criarTreeview(32);
        $this->view->tree;
    }
}
