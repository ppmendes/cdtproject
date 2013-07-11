<?php

class Application_Model_CronogramaOrcamentario
{
    private $total;

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_CronogramaOrcamentario();
        $cronograma_orcamentario = $table->find($id)->current();
        return $cronograma_orcamentario;
    }

    public function insert($data)
    {
        $decimalfilter = new Zend_Filter_DecimalFilter();
        $data['cronograma_orcamentario']['valor_a_receber'] = $decimalfilter->filter($data['cronograma_orcamentario']['valor_a_receber']);
        $data['cronograma_orcamentario']['valor_recebido'] = $decimalfilter->filter($data['cronograma_orcamentario']['valor_recebido']);
        $table = new Application_Model_DbTable_CronogramaOrcamentario();
        $table->insert($data['cronograma_orcamentario']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "cronograma_orcamentario";
        $deletado = true;
        $where = $db->quoteInto('cronograma_orcamentario_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);
    }

    public function update($data, $id)
    {
        $decimalfilter = new Zend_Filter_DecimalFilter();
        $data['cronograma_orcamentario']['valor_a_receber'] = $decimalfilter->filter($data['cronograma_orcamentario']['valor_a_receber']);
        $data['cronograma_orcamentario']['valor_recebido'] = $decimalfilter->filter($data['cronograma_orcamentario']['valor_recebido']);
        unset($data['cronograma_orcamentario']['nomeProjeto']);
        unset($data['cronograma_orcamentario']['saldo']);
        unset($data['cronograma_orcamentario']['orcamento']);
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "cronograma_orcamentario";
        $where = $db->quoteInto('cronograma_orcamentario_id = ?', $id);
        $db->update($table, $data['cronograma_orcamentario'],$where);
    }

    public function selectAll($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('c' => 'cronograma_orcamentario'))
                ->where('p.projeto_id = ' . $id . ' AND c.deletado = 0')
             ->joinLeft(array('p' => 'projeto'), 'c.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id',
             'p.nome'=>'p.nome'));
            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectAllTotal($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $resultado = $db->fetchAll("SELECT SUM( c.valor_recebido ), SUM( c.valor_a_receber )
                                        FROM cronograma_orcamentario AS c
                                        WHERE c.projeto_id = " . $id . " AND c.deletado = 0;");

            return $resultado;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectTotalRubricas($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $resultado = $db->fetchAll("SELECT SUM( valor_orcamento ) AS valor_orcamento
                                         FROM orcamento
                                         WHERE projeto_id = ". $id . " AND deletado = 0;");

            return $resultado;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions(){
        try{
            //$options2 = array();
            $options = array();
            $table = new Application_Model_DbTable_Projeto();
            $resultado = $table->fetchAll();

            foreach($resultado as $item){
                $options[] = array('label' => $item['nome'], 'id' => $item['projeto_id']);
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public static function getDataModificacao($id)
    {
        try
        {
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('p' => 'projeto'),
                array('p.data_final'))
                ->where('p.projeto_id = ?', $id);
            $stmt = $select->query();

            $result = $stmt->fetchAll();
            return $result;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
        
        public function receber($id, $valor, $date) {
            $table = new Application_Model_DbTable_CronogramaOrcamentario();
            $cronograma_orcamentario = $table->find($id)->current();

            $data['cronograma_orcamentario'] = array();
            //$aux = $cronograma_orcamentario['valor_aplicado_a_rubrica'];
            $data['cronograma_orcamentario']['data_pagamento'] = $date;
            $decimalfilter = new Zend_Filter_DecimalFilter();
            $data['cronograma_orcamentario']['valor_recebido'] = $decimalfilter->filter($valor);

            $db = Zend_Db_Table::getDefaultAdapter();
            $table = "cronograma_orcamentario";
            $where = $db->quoteInto('cronograma_orcamentario_id = ?', $id);
            $db->update($table, $data['cronograma_orcamentario'],$where);
        }

    public function getSaldoDisponivel($id){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->select()
                     ->from("cronograma_orcamentario", array('valor_recebido' => 'valor_recebido'))
                     ->where("cronograma_orcamentario_id = " . $id . " AND deletado = 0");

        $stmt = $result->query();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }
    
    public function getOrcamentoUtilizado($id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $resultado = $db->fetchAll("SELECT SUM( valor ) as valor
                                         FROM orcamento_cronograma AS oc
                                         WHERE oc.cronograma_orcamentario_id = $id AND oc.deletado = 0");
        return $resultado;
    }

//        public function calculaTotal($cronogramaOrcamentario)
//        {
//            $total = 0;
//            for($i=0 ; $i<sizeOf($cronogramaOrcamentario) ; $i++)
//            {
//                $total = $total + ($cronogramaOrcamentario[$i]['valor_aplicado_a_rubrica']);
//            }
//        return $total;
//        }
}

