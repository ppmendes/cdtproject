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

    public function selectAll($usuario_logado)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->fetchAll("SELECT IG.nome_instituicao_gerencia, P.projeto_id, P.nome, P.apelido, P.data_inicio, P.data_final, P.data_final_real, U.nome as coordenador, P.percentagem_completo, EP.nome_estado, PRI.nome_prioridade
from projeto as P inner join estado_projeto as EP on P.estado_projeto_id=EP.estado_projeto_id
     inner join prioridade as PRI on P.prioridade_id=PRI.prioridade_id
     inner join instituicao_gerencia as IG on P.instituicao_gerencia_id=IG.instituicao_gerencia_id
     inner join usuario as U on P.coordenador_tecnico=U.usuario_id
     inner join projeto_usuario as PU on P.projeto_id=PU.projeto_id where PU.usuario_id=$usuario_logado and P.deletado=0");


            return $select;
        }catch(Exception $e){
           echo $e->getMessage();
        }
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Projeto();
            $resultado = $table->fetchAll(null,'nome asc');

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

    public static function getValorOrcamento($id)
    {
        try
        {
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('p' => 'projeto'),
                        array('p.orcamento'))
                ->where('p.projeto_id = ?', $id);
            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;

        }catch(Exception $e){
            echo $e->getMessage();
        }

    }

    public static function getNome($id)
    {
        try
        {
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('p' => 'projeto'),
                        array('p.nome', 'p.coordenador_tecnico'))
                ->where('p.projeto_id = ?', $id)
                ->joinLeft(array('u' => 'usuario'), 'p.coordenador_tecnico = u.usuario_id',array('u.usuario_id' => 'u.usuario_id',
                'u.username'=>'u.username', 'u.email'=>'u.email', 'u.telefone' => 'u.telefone', 'u.celular'=> 'u.celular'));

            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

