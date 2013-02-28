<?php

class TarefasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $tarefaModel = new Application_Model_Tarefa();
        $this->view->tarefas = $tarefaModel->selectAll();

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Tarefas();
        $form->startform();
        $model = new Application_Model_Tarefa();
        $modeltarefadepen=new Application_Model_TarefasDependentes();

        $id = $this->_getParam('tarefa_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
                //print_r($form->getValues());
                //exit;
//                echo "</pre>";
                $data = $form->getValues();

                $tarefaDependencia=$data['tarefas']['dependencia_tarefa'];

                $rhAsociado=$data['tarefas']['asociado_tarefa'];
                $rhAsociado=$data['tarefas']['percentagem_trabalho'];


                if($id){ //update
                    //$model->update($data, $id);
                    $modeltarefadepen->update($tarefaDependencia, $id);

                }else{ //insert

                   // $model->insert($data);
                    for($i=0;$i <= $tarefaDependencia.count(); $i++)
                    {
                        $modeltarefadepen->insert();
                    }

                }

                $this->_redirect('/tarefas/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){

                //$projeto_id_controller=$data['tarefas']['projeto_id'];
                $form->setAction('/tarefas/detalhes/tarefa_id/' . $id);
                //$form->setIdProjeto($projeto_id_controller);
                $form->startform();
                $form->populate(array("tarefas" => $data));
            }
        }
        $this->view->form = $form;
    }

    public function selecttarefasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id',0)) {
            $id = (int) $this->_request->getParam('id',0);
            $filhos = new Application_Model_DbTable_Tarefa();
            $rows = $filhos->fetchAll('projeto_id = ' . (int) $id);

            foreach ($rows as $row) {
                echo '<option value="' . $row->tarefa_id . '">' . $row->nome . '</option>';
            }
        } else {

            echo '<option value="">Nenhum</option>';
        }
    }

    public function selectusuariosAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id',0)) {
            $id = (int) $this->_request->getParam('id',0);

            $db = Zend_Db_Table::getDefaultAdapter();
            $rows = $db->fetchAll("select usuario.usuario_id, usuario.nome from usuario inner join projeto_usuario on usuario.usuario_id = projeto_usuario.usuario_id where projeto_id = $id");

            foreach ($rows as $row) {
                echo '<option value="' . $row['usuario_id'] . '">' . $row['nome'] . '</option>';
            }
        } else {

            echo '<option value="">Nenhum</option>';
        }
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Tarefas();
        $detalhes->startform();
        $model = new Application_Model_Tarefa();
        $id = $this->_getParam('tarefa_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/tarefas/detalhes/tarefa_id/' . $id);
            $detalhes->populate(array("tarefas" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Tarefas();
        $model = new Application_Model_Tarefa();
        $id = $this->_getParam('tarefa_id');

        $model->delete($id);
        $this->_redirect('/tarefas/');

        $this->view->excluir = $excluir;
    }

    public function treeviewAction()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('iframe');
        $model = new Application_Model_Tarefa();
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

}

