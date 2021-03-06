<?php
/**
 * Created by JetBrains PhpStorm.
 * User: USUARIOaaaaaaaa
 * Date: 19/09/12
 * Time: 04:04 PM
 * To change this template use File | Settings | File Templates.
 */
class ArquivosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $arquivoModel = new Application_Model_Arquivo;
        $this->view->arquivos = $arquivoModel->selectAll();
    }

    public function adicionarAction(){

        $request = $this->getRequest();
        $form = new Application_Form_Arquivos();
        $form->startform();
        $upload = new Zend_File_Transfer_Adapter_Http();
        $model = new Application_Model_Arquivo;
        $id = $this->_getParam('arquivo_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                $usuario_logado = Zend_Auth::getInstance()->getStorage()->read();
                $data['arquivos']['dono_arquivo']=$usuario_logado->usuario_id;
                unset($data['arquivos']['ac']);
                unset($data['arquivos']['nomeProjeto']);

                if($id){//update

                    $data=$model->verificarMudancasArquivos($data,$id);

                    // verificando que o arquivo foi modificado
                    if($data['arquivos']['tamanho']==-1){
                        $tamanho = $upload->getFileInfo('nome_arquivo');
                        $data['arquivos']['tamanho']=$tamanho['nome_arquivo']['size'];
                    }
                    //verificando que nao tenha tarefa
                    if($data['arquivos']['tarefa_id']==''){
                        $data['arquivos']['tarefa_id']=null;
                    }
                    $model->update($data, $id);

                }
                else{//insert
                    //recuperando o tamanho do arquivo
                    $tamanho = $upload->getFileInfo('nome_arquivo');
                    $data['arquivos']['tamanho']=$tamanho['nome_arquivo']['size'];

                    // no primeiro upload a versao sera sempre 0.1
                    $data['arquivos']['versao']=0.1;
                    $nome_arquivo= $model->getLastInsertedId();

                    $data=$model->editarArquivo($nome_arquivo,$data);
                    $model->insert($data);
                }
                $this->_redirect('/arquivos/');
            }
        }
        elseif ($id){
            $data = $model->find($id)->toArray();
               if(is_array($data)){

                   $id_projeto = $data['projeto_id'];

                   $form->setAction('/arquivos/detalhes/arquivo_id/' . $id);
                   $form->setIdProjeto($id_projeto);
                   $form->startform();

                   $db = Zend_Db_Table::getDefaultAdapter();
                   $nome_projeto=$db->fetchRow("select nome from projeto where projeto_id=$id_projeto");
                   $data['nomeProjeto']=$nome_projeto['nome'];
                   $form->populate(array("arquivos" => $data));
                }
            }
        $this->view->form = $form;
    }

    public function detalhesAction(){
        //$request = $this->getRequest();
        $detalhes = new Application_Form_Arquivos();
        $detalhes->startform();
        $model = new Application_Model_Arquivo;
        $id = $this->_getParam('arquivo_id');
        $this->view->id = $id;

        $data = $model->find($id)->toArray();
        $id_projeto = $data['projeto_id'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $nome_projeto=$db->fetchRow("select nome from projeto where projeto_id=$id_projeto");
        $data['nomeProjeto']=$nome_projeto['nome'];


        if(is_array($data)){
            $detalhes->setAction('/arquivos/detalhes/arquivo_id/' . $id);
            $detalhes->populate(array("arquivos" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Arquivos();
        $model = new Application_Model_Arquivo;
        $id = $this->_getParam('arquivo_id');

        $model->delete($id);

        $this->_redirect('/arquivos/');

        $this->view->excluir = $excluir;
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
}