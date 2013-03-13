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
        $modelusuarios=new Application_Model_UsuariosAssociadosTarefa();

        $id = $this->_getParam('tarefa_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
                //print_r($form->getValues());
                //exit;
//                echo "</pre>";

                $data = $form->getValues();

                $usuario_logado = Zend_Auth::getInstance()->getStorage()->read();
                $data['tarefas']['criador']=$usuario_logado->usuario_id;

                $tarefaDependencia=$data['tarefas']['dependencia_tarefa'];
                $rhAssociados=$data['tarefas']['asociado_tarefa'];

                unset($data['tarefas']['ac'],$data['tarefas']['todas_tarefas'],$data['tarefas']['dependencia_tarefa']);
                unset($data['tarefas']['recursos_humanos'],$data['tarefas']['percentagem_trabalho'],$data['tarefas']['asociado_tarefa']);
                unset($data['tarefas']['comentario_email'],$data['tarefas']['aca']);

                if($id){ //update
                    $model->update($data, $id);
                    // update na tabela tarefas_dependentes;
                    $modeltarefadepen->delete($id);
                    for($i=0;$i < count($tarefaDependencia); $i++)
                    {
                        $datatd['tarefa_id']=$id;
                        $datatd['tarefa_dependente']=$tarefaDependencia[$i];
                        $modeltarefadepen->insert($datatd);
                    }
                    //update na tabela usuarios dependentes
                    $modelusuarios->delete($id);
                    for($i=0;$i<count($rhAssociados); $i++)
                    {
                        $datarh['tarefa_id']=$id;
                        $dataexplode=explode('|',$rhAssociados[$i]);
                        $datarh['usuario_id']=$dataexplode[0];
                        $datarh['porcentagem']=$dataexplode[1];
                        $modelusuarios->insert($datarh);

                    }


                }else{ //insert

                    //insert na tabela tarefa
                    $model->insert($data);

                    // insert na tabela tarefas_dependentes;
                    //determinado o ide da tarefa
                    $idtarefa= $model->getLastInsertedId();
                    for($i=0;$i < count($tarefaDependencia); $i++)
                    {
                        $datatd['tarefa_id']=$idtarefa;
                        $datatd['tarefa_dependente']=$tarefaDependencia[$i];
                        $modeltarefadepen->insert($datatd);
                    }

                    //insert tabela usuarios associados
                    for($i=0;$i<count($rhAssociados); $i++)
                    {
                        $datarh['tarefa_id']=$idtarefa;
                        $dataexplode=explode('|',$rhAssociados[$i]);
                        $datarh['usuario_id']=$dataexplode[0];
                        $datarh['porcentagem']=$dataexplode[1];
                        $modelusuarios->insert($datarh);

                    }

                }

                $this->_redirect('/tarefas/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){

                $id_projeto = $data['projeto_id'];
                $id_instituicao=$data['instituicao_id'];
                $id_tarefa=$data['tarefa_id'];
                $form->setAction('/tarefas/detalhes/tarefa_id/' . $id);
                $form->setIdProjeto($id_projeto);
                $form->setIdTarefa($id_tarefa);
                $form->startform();

                $db = Zend_Db_Table::getDefaultAdapter();
                $nome_projeto=$db->fetchRow("select nome from projeto where projeto_id=$id_projeto");
                $nome_instituicao=$db->fetchRow("select nome from instituicao where instituicao_id=$id_instituicao");
                $data['ac']=$nome_projeto['nome'];
                $data['aca']=$nome_instituicao['nome'];
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
        $model = new Application_Model_Tarefa();
        $id = $this->_getParam('tarefa_id');
        $this->view->id = $id;

        $data = $model->find($id)->toArray();

        $id_projeto=$data['projeto_id'];
        $id_instituicao=$data['instituicao_id'];
        $id_tarefa=$data['tarefa_id'];
        $detalhes->setIdProjeto($id_projeto);
        $detalhes->setIdTarefa($id_tarefa);
        $detalhes->startform();
        $db = Zend_Db_Table::getDefaultAdapter();
        $nome_projeto=$db->fetchRow("select nome from projeto where projeto_id=$id_projeto");
        $nome_instituicao=$db->fetchRow("select nome from instituicao where instituicao_id=$id_instituicao");
        $data['ac']=$nome_projeto['nome'];
        $data['aca']=$nome_instituicao['nome'];

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

