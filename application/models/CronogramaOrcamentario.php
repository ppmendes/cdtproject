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

        //        $str = $data['cronograma_orcamentario']['valor_a_receber'];
//        $temp = str_replace(".", "", $str);
//        $valor_a_receber = str_replace(",", ".",$temp);
        //      $data['cronograma_orcamentario']['valor_a_receber'] = $valor_a_receber;

//        $str = $data['cronograma_orcamentario']['valor_recebido'];
//        $temp = str_replace(".", "", $str);
//        $valor_recebido = str_replace(",", ".",$temp);
//        $data['cronograma_orcamentario']['valor_recebido'] = $valor_recebido;

        $table = new Application_Model_DbTable_CronogramaOrcamentario();
        $table->insert($data['cronograma_orcamentario']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "cronograma_orcamentario";
        //$deletado = true;
        $where = $db->quoteInto('cronograma_orcamentario_id = ?', $id);
        //$data = array('deletado' => $deletado);

        //$db->update($table, $data, $where);
        $db->delete($table, $where);

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
                ->where('p.projeto_id = ?', $id)
             ->joinLeft(array('p' => 'projeto'), 'c.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id',
             'p.nome'=>'p.nome'));
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

