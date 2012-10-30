<?php

class TermoaditivoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $termoAditivoModel = new Application_Model_TermoAditivo();
        $id = $this->_getParam('projeto_id');
        $this->view->id = $id;
        $this->view->termoaditivo = $termoAditivoModel->selectAll($id);

    }

    public function prorrogarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_TermoAditivo_Prorrogar();
        $model = new Application_Model_TermoAditivo;

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                $data = $form->getValues();
                unset($data['termo_aditivo']['data']);
                $model->insert($data);

                $this->_redirect('/termoaditivo/index/projeto_id/' . $data['termo_aditivo']['projeto_id']);
            }
        }/*elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/termoaditivo/prorrogar/projeto_id/' . $id);
                $form->populate(array("termoaditivo" => $data));
            }
        }    */

        $this->view->form = $form;


    }

    public function remanejarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_TermoAditivo_Remanejar();
        $model = new Application_Model_TermoAditivo;
        //$id = $this->_getParam('projeto_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                $data = $form->getValues();
                unset($data['termo_aditivo']['termoAditivoRemanejar1']);
                unset($data['termo_aditivo']['termoAditivoRemanejar2']);
                $model->insert($data);

                $this->_redirect('/termoaditivo/index/projeto_id/' . $data['termo_aditivo']['projeto_id']);
            }
        }/*elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/termoaditivo/index/projeto_id/' . $id);
                $form->populate(array("termoaditivo" => $data));
            }
        }   */

        $this->view->form = $form;


    }

    public function alterarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_TermoAditivo_Alterar();
        $model = new Application_Model_TermoAditivo;
        //$id = '1';//$this->_getParam('projeto_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                $data = $form->getValues();
                unset($data['termo_aditivo']['termoAditivoAlterar']);
                    $model->insert($data);

                $this->_redirect('/termoaditivo/index/projeto_id/' . $data['termo_aditivo']['projeto_id']);
            }
        }/*elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/termoaditivo/index/projeto_id/' . $id);
                $form->populate(array("termoaditivo" => $data));
            }
        } */

        $this->view->form = $form;


    }


}

