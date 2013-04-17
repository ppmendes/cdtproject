<?php

class Application_Model_Cidade
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Cidade;
		$cidade = $table->find($id)->current();
		return $cidade;
	}

    public function insert($cidade)
    {

    }

    public function delete($id)
    {

    }

    public function update($cidade)
    {

    }

    public static function getOptions($id_cidade_form = null){
        try{
            if($id_cidade_form==null)
            {
                $options = array();
                $table = new Application_Model_DbTable_Cidade();
                $resultado = $table->fetchAll();
                foreach($resultado as $item){
                    $options[$item['cidade_id']] = $item['cidade_nome'];
                }
                return $options;
            }else{
                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select cidade_id, cidade_nome from cidade where cidade_id = $id_cidade_form");

                foreach($resultado as $item){
                    $options[$item['cidade_id']] = $item['cidade_nome'];
                }
                return $options;
            }
        }catch (Exception $e){

        }

    }
}

