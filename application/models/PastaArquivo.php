<?php

class Application_Model_PastaArquivo
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PastaArquivo;
        $pasta_arquivo = $table->find($id)->current();
        return $pasta_arquivo;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_PastaArquivo();
        $table->insert($data['pasta_arquivos']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "pasta_arquivo";
        $deletado = true;
        $where = $db->quoteInto('pasta_arquivo_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Projeto;
        $where = $table->getAdapter()->quoteInto('pasta_arquivo_id = ?',$id);

        $table->update($data['pasta_arquivos'],$where);
    }

    public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('p' => 'projeto'))
                ->where('p.deletado = ?', false)
                ->joinLeft(array('ep' => 'estado_projeto'), 'p.estado_projeto_id = ep.estado_projeto_id')
                ->joinLeft(array('pr' => 'prioridade'), 'p.prioridade_id = pr.prioridade_id')
                ->joinLeft(array('ct' => 'usuario'), 'p.coordenador_tecnico = ct.usuario_id',array('ct.usuario_id'=>'ct.usuario_id','ct.nome'=>'ct.nome','ct.sobrenome'=>'ct.sobrenome'))
                ->joinLeft(array('ga' => 'instituicao_gerencia'), 'p.instituicao_gerencia_id = ga.instituicao_gerencia_id',array(
                'ga.instituicao_gerencia_id'=>'ga.instituicao_gerencia_id','ga.nome_instituicao_gerencia'=>'ga.nome_instituicao_gerencia'));
            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_PastaArquivo();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['pasta_arquivo_id']] = $item['nome_pasta'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}
