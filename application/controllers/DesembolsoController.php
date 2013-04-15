<?php

class DesembolsoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $model = new Application_Model_Desembolso();
        $id = $this->_getParam('projeto_id');
        $this->view->resultado = $model->selectAll($id);
        $this->view->id = $id;
    }

//    public function indexajaxAction()
//    {
////        $desembolsoModel = new Application_Model_Desembolso();
////        $array_desembolso = $desembolsoModel->selectAll();
////
////        foreach($array_desembolso as &$item){
////        $item[0]="<a href='/desembolso/detalhes/desembolso_id/{$item[0]}'>$item[0]</a>";
////
////        //$item[7]="<a href='/empenhos/detalhes/empenho_id/{$item[7]}'>$item[7]</a>";
////        }
////        echo '{"aaData":'.json_encode($array_desembolso).'}';
////        exit;
//        $model = new Application_Model_Desembolso();
//        echo '{"aaData":'.json_encode($model->selectAll()).'}';
//        exit;
//    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $pid = $this->_getParam('projeto_id');
        $form = new Application_Form_Desembolso();
        $form->setProjetoId($pid);
        $form->startform();
        $model = new Application_Model_Desembolso;

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
//                print_r($form->getValues());
//                echo "</pre>";
                $data = $form->getValues();

                $model->insert($data);

                $this->_redirect('/desembolso/');
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $id = $this->_getParam('desembolso_id');
        $pid = $this->_getParam('projeto_id');
        $detalhes = new Application_Form_Desembolso();
        $detalhes->setProjetoId($pid);
        $detalhes->startform();
        $model = new Application_Model_Desembolso;
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/desembolso/detalhes/desembolso_id/' . $id);
            $detalhes->populate(array("desembolso" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function extornarAction(){
        //$request = $this->getRequest();
        $extorno = new Application_Form_Desembolso();
        $model = new Application_Model_Desembolso;
        $id = $this->_getParam('desembolso_id');

        $model->delete($id);
        $this->_redirect('/desembolso/');

        $this->view->extornar = $extorno;

    }


}

