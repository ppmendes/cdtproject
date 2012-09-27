<?php

class InstituicoesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('i' => 'instituicao'))
            ->join(array('p' => 'pais'), 'i.pais_id = p.pais_id')
            ->join(array('e' => 'estados'), 'i.estados_id = e.estados_id')
            ->join(array('c' => 'cidade'), 'i.cidade_id = c.cidade_id')
            ->join(array('d' => 'denominacao'), 'i.denominacao_id = d.denominacao_id');

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        $this->view->instituicao = $result;

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Instituicoes();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                echo "<pre>";
                print_r($form->getValues());
                echo "</pre>";
            }
        }

        $this->view->form = $form;
    }


}

