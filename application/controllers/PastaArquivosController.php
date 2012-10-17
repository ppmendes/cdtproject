<?php

class PastaArquivosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $pastaarquivoModel = new Application_Model_PastaArquivo();
        $this->view->pastaarquivo = $pastaarquivoModel->selectAll();

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_PastaArquivos();
        $model = new Application_Model_PastaArquivo();
        $id = $this->_getParam('pasta_arquivo_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
//                print_r($form->getValues());
//                echo "</pre>";
                $data = $form->getValues();

                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/arquivos/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/pastaarquivos/detalhes/pasta_arquivo_id/' . $id);
                $form->populate(array("pasta_arquivos" => $data));
            }
        }

        $this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_PastaArquivos();
        $model = new Application_Model_PastaArquivo();
        $id = $this->_getParam('pasta_arquivo_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();



        if(is_array($data)){
            $detalhes->setAction('/pastaarquivos/detalhes/pasta_arquivo_id/' . $id);
            $detalhes->populate(array("pasta_arquivos" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_PastaArquivos();
        $model = new Application_Model_PastaArquivo();
        $id = $this->_getParam('pasta_arquivo_id');

        $model->delete($id);
        //$this->_redirect('/arquivos/');

        $this->view->excluir = $excluir;

    }


}

