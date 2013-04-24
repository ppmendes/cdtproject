<?php

class OrcamentosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $orcamentoModel = new Application_Model_Orcamento();
        $pid = $this->_getParam('projeto_id');
        $this->view->orcamentos = $orcamentoModel->selectAll($pid);
        $this->view->pid = $pid;
        $this->view->orcamentoProjeto = $orcamentoModel->getOrcamentoProjeto($pid);



    }

    public function adicionarAction(){

        $id = $this->_getParam('orcamento_id');
        $pid= $this->_getParam('projeto_id');
        $request = $this->getRequest();
        $form = new Application_Form_Orcamentos();
        $model = new Application_Model_Orcamento();
        $orcamento = $model->selectAll($pid);
        $totalParcelas = $model->calculaTotal($orcamento);
        $form->setValorParcelas($totalParcelas);
        $form->setProjetoId($pid);
        $form->startform();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();

                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/orcamentos/index/projeto_id/'.$data['orcamento']['projeto_id']);
            }
            $this->view->form = $form;

        }elseif ($id){
            $data = $model->find($id)->toArray();


            if(is_array($data)){
                $form->setAction('/orcamentos/detalhes/orcamento_id/' . $id);
                $form->setProjetoId($pid);
                $form->startform();
                $form->populate(array("orcamento" => $data));
                $this->view->form = $form;

            }
        }else

        $form->setProjetoId($pid);
        $form->startform();
        $this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Orcamentos();
        $model = new Application_Model_Projeto();
        $modelorc = new Application_Model_Orcamento();
        $id = $this->_getParam('orcamento_id');
        $this->view->id = $id;


        $data = $modelorc->find($id)->toArray();
        //print_r($data);
        //exit;
        if(is_array($data)){
            $detalhes->setAction('/orcamentos/detalhes/orcamento_id/' . $id);
            $detalhes->setProjetoId($data['projeto_id']);
            $detalhes->setRubricaId($data['rubrica_id']);
            $detalhes->startform();
            $detalhes->setDefault("descricao_orcamento", $data['descricao_orcamento']);
            $detalhes->setDefault("descricao_orcamento", $data['descricao_orcamento']);
            $detalhes->setDefault("objetivo_orcamento", $data['objetivo_orcamento']);
            $detalhes->setDefault("valor_orcamento", $data['valor_orcamento']);
            $detalhes->setDefault("destinatario_id", $data['destinatario_id']);
            $detalhes->populate(array("orcamentos" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function combogridrubricaAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');

        $searchTerm = $this->_getParam('searchTerm');

        if(!$sidx){
            $sidx = 'rubrica_id';
            $sord = 'ASC';
        }
        if ($searchTerm=="") {
            $searchTerm="%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $where = 'rubrica_id_pai != 1 and rubrica_id_pai != 2 and rubrica_id_pai != 0 and (codigo_rubrica like ? or descricao like ? )';//, 'codigo_rubrica like '.$searchTerm);

        $select = $dbAdapter->select()->from('rubrica',array('count(*) as count'))->where($where,$searchTerm);

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
        $select = $dbAdapter->select()->from('rubrica',array('rubrica_id','descricao','codigo_rubrica'))->where($where,$searchTerm)
        ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from('rubrica',array('rubrica_id','descricao','codigo_rubrica'))->where($where,$searchTerm)
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

    public function combogridprojetoAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');

        $searchTerm = $this->_getParam('searchTerm');

        if(!$sidx){
            $sidx = 'projeto_id';
            $sord = 'ASC';
        }
        if ($searchTerm=="") {
            $searchTerm="%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $where = 'nome like ? or apelido like ?';

        $select = $dbAdapter->select()->from('projeto',array('count(*) as count'))->where($where,$searchTerm);

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
            $select = $dbAdapter->select()->from('projeto',array('projeto_id','nome','apelido'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from('projeto',array('projeto_id','nome','apelido'))->where($where,$searchTerm)
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

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Orcamentos();
        $excluir->startform();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('orcamento_id');

        $model->delete($id);
        $this->_redirect('/orcamentos/');

        $this->view->excluir = $excluir;

    }


}

