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
        $aux = $model->selectAll($pid);
        $beneModel = new Application_Model_Beneficiario();
        $orcModel = new Application_Model_Orcamento();
        $rubModel = new Application_Model_Rubrica();
        
        $desModel = new Application_Model_Desembolso();
        for($i = 0; $i < sizeof($aux); $i++) {
            $bene = $beneModel->find($aux[$i]['beneficiario_id']);
            $aux[$i]['beneficiario_nome'] = $bene['nome'];
            
            $orcamento = $orcModel->find($aux[$i]['orcamento_id']);
            $rubrica = $rubModel->find($orcamento['rubrica_id']);
            $aux[$i]['rubrica_descricao'] = $rubrica['descricao'];
            
            $totaldesembolsado = $desModel->selectSaldoEmpenho($aux[$i]['empenho_id']);
            $aux[$i]['valor_executado'] = $totaldesembolsado[0]['SUM( valor_desembolso )'];
        }
        $this->view->resultado = $aux;
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
        //$form->setBeneficiarioId(0);
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
        $detalhes = new Application_Form_Empenhos();
        $detalhes->setProjetoId($pid);
        $detalhes->startform();
        $model = new Application_Model_Empenho;
        $beneficiarioModel = new Application_Model_Beneficiario();

        $this->view->id = $id;
        $this->view->pid = $pid;

        $data = $model->find($id)->toArray();

        $data['beneficiario'] = $beneficiarioModel->getNome($data['beneficiario_id'])[0]['nome'];

        if(is_array($data)){
            $detalhes->setAction('/empenhos/detalhes/empenho_id/' . $id . '/projeto_id/' . $pid);
            $detalhes->populate(array("empenhos" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        $model = new Application_Model_Empenho;
        $id = $this->_getParam('empenho_id');
        $pid = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/empenhos/index/projeto_id/'.$pid);

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
            $select = $dbAdapter->select()->from(array('b' => 'beneficiario') ,array('beneficiario_id', 'nome', 'cpf_cnpj'))
                                          ->where($where,$searchTerm)
                                          ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from(array('b'=>'beneficiario'),array('beneficiario_id', 'nome', 'cpf_cnpj'))
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

