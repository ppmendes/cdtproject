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
                $model->atualizaData($data['termo_aditivo']['data_fim_nova'], $data['termo_aditivo']['projeto_id']);

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

        //$form->setProjetoId($pid);
        $form->startform();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                $data = $form->getValues();

                //unset($data['termo_aditivo']['termoAditivoRemanejar1']);
                //unset($data['termo_aditivo']['termoAditivoRemanejar2']);
                $model->insertRemanejar($data);

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

        $form->startform();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                $data = $form->getValues();


                unset($data['termo_aditivo']['saldo_orcamento']);

                $model->insertAlterar($data);

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

    public function combogridrubricaAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');
        $pid = $this->_getParam('projeto_id');

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

        $where = 'o.projeto_id = ' . $pid . ' AND (codigo_rubrica like ? or descricao like ? ) AND (r.rubrica_id <> 44 AND rubrica_id_pai <> 44)';//, 'codigo_rubrica like '.$searchTerm);

        $select = $dbAdapter->select()->from(array('r' => 'rubrica'),array('count(*) as count'))->where($where,$searchTerm)
            ->joinLeft(array('o' => 'orcamento'), 'r.rubrica_id = o.rubrica_id',array('o.projeto_id'=>'o.projeto_id'));

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
            $select = $dbAdapter->select()
                ->from(array('o' => 'orcamento'), array('orcamento_id'=>'o.orcamento_id', 'valor_orcamento'=>'o.valor_orcamento', 'rubrica_id' => 'r.rubrica_id'))
                ->where('p.projeto_id = ' . $pid . ' AND p.deletado = 0 AND o.deletado = 0 AND (r.rubrica_id <> 44 AND rubrica_id_pai <> 44)')
                ->joinInner(array('r' => 'rubrica'), 'o.rubrica_id = r.rubrica_id', array('codigo_rubrica'=>'r.codigo_rubrica', 'descricao'=>'r.descricao'))
                ->joinInner(array('d' => 'destinatario'), 'o.destinatario_id = d.destinatario_id', array('d.nome_destinatario'=>'d.nome_destinatario'))
                ->joinInner(array('p' => 'projeto'), 'o.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id'))
                ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()
                ->from(array('o' => 'orcamento'), array('orcamento_id'=>'o.orcamento_id', 'valor_orcamento'=>'o.valor_orcamento', 'rubrica_id' => 'r.rubrica_id'))
                ->where('p.projeto_id = ' . $pid . ' AND p.deletado = 0 AND o.deletado = 0 AND (r.rubrica_id <> 44 AND rubrica_id_pai <> 44)')
                ->joinInner(array('r' => 'rubrica'), 'o.rubrica_id = r.rubrica_id', array('codigo_rubrica'=>'r.codigo_rubrica', 'descricao'=>'r.descricao'))
                ->joinInner(array('d' => 'destinatario'), 'o.destinatario_id = d.destinatario_id', array('d.nome_destinatario'=>'d.nome_destinatario'))
                ->joinInner(array('p' => 'projeto'), 'o.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id'))
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

