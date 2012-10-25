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
        $this->view->arquivo = $arquivoModel->selectAll();
    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Arquivos();
        $upload = new Zend_File_Transfer_Adapter_Http();
        $model = new Application_Model_Arquivo;
        $id = $this->_getParam('arquivo_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                $data = $form->getValues();

                if($id){
                    $tamanho = $upload->getFileInfo('nome_arquivo');


                    $data['arquivos']['tamanho']=$tamanho['nome_arquivo']['size'];
                    $model->verificarMudancasArquivos($data,$id);
                    $model->update($data, $id);
                }else{

                    $tamanho = $upload->getFileInfo('nome_arquivo');
                    $data['arquivos']['nome_arquivo']=
                    $data['arquivos']['tamanho']=$tamanho['nome_arquivo']['size'];
                    $model->insert($data);
                    $nome_arquivo= $model->getLastInsertedId();
                    $model->editarArquivo($nome_arquivo,$data);
                }

                $this->_redirect('/arquivos/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){

                $form->setAction('/arquivos/detalhes/arquivo_id/' . $id);
                $form->populate(array("arquivos" => $data));
            }
        }
        $this->view->form = $form;
    }



    public function detalhesAction(){
        //$request = $this->getRequest();
        $detalhes = new Application_Form_Arquivos();
        $model = new Application_Model_Arquivo;
        $id = $this->_getParam('arquivo_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

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
}