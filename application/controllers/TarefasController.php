<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Harley
 * Date: 19/09/12
 * Time: 15:29
 * To change this template use File | Settings | File Templates.
 */
class TarefasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Tarefas();

        echo "&nbsp;";

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