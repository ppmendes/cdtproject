<?php

class Application_Model_CronogramaFinanceiro
{
    private $total;

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_CronogramaFinanceiro();
        $cronograma_financeiro = $table->find($id)->current();
        return $cronograma_financeiro;
    }

    public function insert($data)
    {
        $str = $data['cronograma_financeiro']['valor_aplicado_a_rubrica'];
        $var = str_replace(".", "", $str);
        $var2 = str_replace(",", ".",$var);
        $data['cronograma_financeiro']['valor_aplicado_a_rubrica'] = $var2;
        unset($data['cronograma_financeiro']['nomeProjeto']);
        unset($data['cronograma_financeiro']['saldo']);
        unset($data['cronograma_financeiro']['orcamento']);
        $table = new Application_Model_DbTable_CronogramaFinanceiro();
        $table->insert($data['cronograma_financeiro']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "cronograma_financeiro";
        $deletado = true;
        $where = $db->quoteInto('cronograma_financeiro_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);
    }

    public function update($data, $id)
    {
        $decimalfilter = new Zend_Filter_DecimalFilter();

        $data['cronograma_financeiro']['valor_recebido'] = $decimalfilter->filter($data['cronograma_financeiro']['valor_recebido']);

        unset($data['cronograma_financeiro']['nomeProjeto']);
        unset($data['cronograma_financeiro']['saldo']);
        unset($data['cronograma_financeiro']['orcamento']);
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "cronograma_financeiro";
        $where = $db->quoteInto('cronograma_financeiro_id = ?', $id);
        $db->update($table, $data['cronograma_financeiro'],$where);
    }

    public function selectAll($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('c' => 'cronograma_financeiro'))
                ->where('p.projeto_id = ' . $id . ' AND c.deletado = 0')
             ->joinLeft(array('p' => 'projeto'), 'c.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id',
             'p.nome'=>'p.nome'));
               //->joinLeft(array('d' => 'desembolso'), 'c.prioridade_id = pr.prioridade_id');
//                ->joinLeft(array('ct' => 'usuario'), 'p.coordenador_tecnico = ct.usuario_id',array('ct.usuario_id'=>'ct.usuario_id','ct.nome'=>'ct.nome','ct.sobrenome'=>'ct.sobrenome'))
//                ->joinLeft(array('ga' => 'instituicao_gerencia'), 'p.instituicao_gerencia_id = ga.instituicao_gerencia_id',array(
//                'ga.instituicao_gerencia_id'=>'ga.instituicao_gerencia_id','ga.nome_instituicao_gerencia'=>'ga.nome_instituicao_gerencia'));
            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
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

        public function calculaTotal($cronogramaFinanceiro)
        {
            $total = 0;
            for($i=0 ; $i<sizeOf($cronogramaFinanceiro) ; $i++)
            {
                $total = $total + ($cronogramaFinanceiro[$i]['valor_aplicado_a_rubrica']);
            }
        return $total;
        }
        
        public function receber($id, $valor, $date) {
            $table = new Application_Model_DbTable_CronogramaFinanceiro();
            $cronograma_financeiro = $table->find($id)->current();

            
            $decimalfilter = new Zend_Filter_DecimalFilter();
            
            $data['cronograma_financeiro'] = array();
            $aux = $cronograma_financeiro['valor_aplicado_a_rubrica'];
            $data['cronograma_financeiro']['data_pagamento'] = $date;
            $data['cronograma_financeiro']['valor_recebido'] = $decimalfilter->filter($valor);

            $db = Zend_Db_Table::getDefaultAdapter();
            $table = "cronograma_financeiro";
            $where = $db->quoteInto('cronograma_financeiro_id = ?', $id);
            $db->update($table, $data['cronograma_financeiro'],$where);
        }
}

