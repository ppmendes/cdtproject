<?php

class Application_Model_Projeto
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Projeto;
		$projeto = $table->find($id)->current();
		return $projeto;
	}

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Projeto;
        $table->insert($data['projetos']);
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
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('p' => 'projeto'))
            ->where('p.deletado = ?', false)
            ->joinLeft(array('ep' => 'estado_projeto'), 'p.estado_projeto_id = ep.estado_projeto_id')
            ->joinLeft(array('pr' => 'prioridade'), 'p.prioridade_id = pr.prioridade_id')
            ->joinLeft(array('ct' => 'usuarios'), 'p.coordenador_tecnico = ct.usuario_id',array('ct.usuario_id'=>'ct.usuario_id','ct.nome'=>'ct.nome','ct.sobrenome'=>'ct.sobrenome'))
            ->joinLeft(array('ga' => 'instituicao'), 'p.gerencia = ga.instituicao_id',array('ga.instituicao_id'=>'ga.instituicao_id','ga.nome'=>'ga.nome'));
        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Projeto();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['projeto_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}

