<?php

class Application_Model_Instituicao
{
	/**
	* Busca a Solução e seus respectivos relacionamentos pelo ID da solução
	* Retorna um array com a Solução
	*/
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Instituicao;
        $instituicao = $table->find($id)->current();
        return $instituicao;
    }

    public function insert($instituicao)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($instituicao)
    {

    }

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from('vw_instituicao_projeto_ativo_arquivado',array('instituicao_id','nome','ativo','arquivado','tipo','responsavel'));

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }
}
