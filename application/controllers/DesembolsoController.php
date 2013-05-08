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
        $pid = $this->_getParam('projeto_id');
        $this->view->resultado = $model->selectAll($pid);
        $this->view->orcamentoProjeto = $model->selectOrcamentoProjeto($pid);
        $this->view->soma = $model->selectAllSoma($pid);
        $this->view->pid = $pid;
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

        $model = new Application_Model_Desembolso;

        //$this->view->somaRubricas = $model->selectTotalTiposRubrica($pid);
        $this->view->soma = $model->selectAllSoma($pid);

        $form = new Application_Form_Desembolso();
        $form->setProjetoId($pid);
        $form->startform();


        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
//                print_r($form->getValues());
//                echo "</pre>";
                $data = $form->getValues();

                $model->insert($data);

                $this->_redirect('/desembolso/index/projeto_id/'.$pid);
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
        $this->view->pid = $pid;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/desembolso/detalhes/desembolso_id/' . $id);
            $detalhes->populate(array("desembolso" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function extornarAction(){
        //$request = $this->getRequest();
        $model = new Application_Model_Desembolso;
        $id = $this->_getParam('desembolso_id');
        $pid = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/desembolso/index/projeto_id/' . $pid);

    }

    public function combogridempenhoAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');

        $searchTerm = $this->_getParam('searchTerm');
        $pid = $this->_getParam('projeto_id');

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

        $qtdRubrica = $dbAdapter->fetchAll("SELECT count(*) as count, empenho_id, valor_empenho, descricao_historico, nome,

                  (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                    FROM desembolso AS des
                    WHERE e.empenho_id = des.empenho_id
                  ) AS saldo_empenho

                  FROM empenho AS e
                  LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                  LEFT JOIN beneficiario AS b ON e.beneficiario_id = b.beneficiario_id
                  WHERE o.projeto_id = " . $pid . " AND (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                  FROM desembolso AS des
                  WHERE e.empenho_id = des.empenho_id
                  ) >= 0 AND (nome LIKE " . $searchTerm . " OR descricao_historico LIKE " . $searchTerm . ")");

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
            try
            {

                $rows = $dbAdapter->fetchAll("SELECT empenho_id, valor_empenho, descricao_historico, nome,

                  (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                    FROM desembolso AS des
                    WHERE e.empenho_id = des.empenho_id
                  ) AS saldo_empenho

                  FROM empenho AS e
                  LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                  LEFT JOIN beneficiario AS b ON e.beneficiario_id = b.beneficiario_id
                  WHERE o.projeto_id = " . $pid . " AND (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                  FROM desembolso AS des
                  WHERE e.empenho_id = des.empenho_id
                  ) >= 0 AND (nome LIKE '" . $searchTerm . "' OR descricao_historico LIKE '" . $searchTerm . "')
                  ORDER BY " . $sidx . " " . $sord . "
                  LIMIT " . $start . ", " . $limit);

        } catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }
        else{
            try
            {

                $rows = $dbAdapter->fetchAll("SELECT empenho_id, valor_empenho, descricao_historico, nome,

                  (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                    FROM desembolso AS des
                    WHERE e.empenho_id = des.empenho_id
                  ) AS saldo_empenho

                  FROM empenho AS e
                  LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                  LEFT JOIN beneficiario AS b ON e.beneficiario_id = b.beneficiario_id
                  WHERE o.projeto_id = " . $pid . " AND (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                  FROM desembolso AS des
                  WHERE e.empenho_id = des.empenho_id
                  ) >= 0 AND (nome LIKE '" . $searchTerm . "' OR descricao_historico LIKE '" . $searchTerm . "')
                  ORDER BY " . $sidx . " " . $sord);

            } catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }

        try{

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

