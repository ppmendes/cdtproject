<?php

class Application_Model_CronogramaFinanceiro
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DBTable_CronogramaFinanceiro();
        $cronograma_financeiro = $table->find($id)->current();
        return $cronograma_financeiro;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_CronogramaFinanceiro();
        $table->insert($data['cronograma_financeiro']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "projeto";
        $deletado = true;
        $where = $db->quoteInto('projeto_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Projeto;
        $where = $table->getAdapter()->quoteInto('projeto_id = ?',$id);

        $table->update($data['projetos'],$where);
    }

    public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('c' => 'cronograma_financeiro'))
//                ->where('p.deletado = ?', false)
             ->joinLeft(array('p' => 'projeto'), 'c.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id',
             'p.nome'=>'p.nome'));
//                ->joinLeft(array('pr' => 'prioridade'), 'p.prioridade_id = pr.prioridade_id')
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
}

