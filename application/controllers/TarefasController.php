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
        $id = $this->_getParam('tarefa_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
                //print_r($form->getValues());
                //exit;
//                echo "</pre>";
                $data = $form->getValues();
                print_r($data);
                exit;

                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/tarefas/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $data_inicio=$data['tarefas']['data_inicio'];
                $data_final=$data['tarefas']['data_final'];
                $tipo_duracao=$data['tarefas']['tipo_duracao_id'];
                $form->setAction('/tarefas/detalhes/tarefa_id/' . $id);
                $form->setDatas($data_inicio, $data_final, $tipo_duracao);
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

            echo '<option value="">Nenhum</option>';
            foreach ($rows as $row) {
                echo '<option value="' . $row->tarefa_id . '">' . $row->nome . '</option>';
            }
        } else {

            echo '<option value="">Nenhum</option>';
        }
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Tarefas();
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


}

