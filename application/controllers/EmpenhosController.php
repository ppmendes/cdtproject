<?php

class EmpenhosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $model = new Application_Model_Empenho();
        $pid = $this->_getParam('projeto_id');
        $this->view->resultado = $model->selectAll($pid);
        $this->view->soma = $model->selectAllSoma($pid);
        $this->view->pid = $pid;
    }

//    public function indexajaxAction(){
//        $model = new Application_Model_Empenho();
//        $id = $this->_getParam('projeto_id');
//        echo '{"aaData":'.json_encode($model->selectAll($id)).'}';
//        exit;
//    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $pid = $this->_getParam('projeto_id');
        $form = new Application_Form_Empenhos();
        $form->setProjetoId($pid);
        $form->startform();
        $model = new Application_Model_Empenho;

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                
                $model->insert($data);
                $this->_redirect('/empenhos/index/projeto_id/'.$pid);
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $id = $this->_getParam('empenho_id');
        $pid = $this->_getParam('projeto_id');
        $bid = $this->_getParam('beneficiario_id');
        $detalhes = new Application_Form_Empenhos();
        $detalhes->setProjetoId($pid);
        $detalhes->setBeneficiarioId($bid);
        $detalhes->startform();
        $model = new Application_Model_Empenho;
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/empenhos/detalhes/empenho_id/' . $id);
            $detalhes->populate(array("empenhos" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        $excluir = new Application_Form_Empenhos();
        $model = new Application_Model_Empenho;
        $id = $this->_getParam('id');

        $model->delete($id);
        $this->_redirect('/empenhos/');

        $this->view->excluir = $excluir;

    }

    public function combogridbeneficiarioAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');

        $searchTerm = $this->_getParam('searchTerm');

        if(!$sidx){
            $sidx = 'nome';
            $sord = 'ASC';
        }
        if ($searchTerm=="") {
            $searchTerm="%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $where = 'nome like ? ';

        $select = $dbAdapter->select()->from(array('b'=>'beneficiario'),array('count(*) as count'))
                                      ->where($where,$searchTerm);


        $qtdRubrica = $dbAdapter->fetchAll($select);
        $count = $qtdRubrica[0]['count'];

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        if($total_pages!=0)
        {
            $select = $dbAdapter->select()->from(array('b' => 'beneficiario') ,array('beneficiario_id', 'nome'))
                                          ->where($where,$searchTerm)
                                          ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from(array('b'=>'beneficiario'),array('beneficiario_id', 'nome'))
                                          ->where($where,$searchTerm)
                                          ->order(array("$sidx $sord"));
        }

        try{
            $rows = $dbAdapter->fetchAll($select);

            $response = (object) array();
            $response->page = $page;
            $response->total = $total_pages;
            $response->records = $count;
            $response->rows = $rows;

            echo json_encode($response);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }


        exit;
    }

}

