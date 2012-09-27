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
            ->from(array('i' => 'instituicao'))
            ->joinLeft(array('p' => 'pais'), 'i.pais_id = p.pais_id')
            ->joinLeft(array('e' => 'estados'), 'i.estados_id = e.estados_id')
            ->joinLeft(array('c' => 'cidade'), 'i.cidade_id = c.cidade_id')
            ->joinLeft(array('d' => 'denominacao'), 'i.denominacao_id = d.denominacao_id');

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }
}
