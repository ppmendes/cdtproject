<?php

class Application_Model_Escolaridade
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Escolaridade;
		$escolaridade = $table->find($id)->current();
		return $escolaridade;
	}
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Escolaridade;
            $escolaridade = $table->fetchAll();
            foreach($escolaridade as $item){
                $options[$item['escolaridade_id']] = $item['nome_escolaridade'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
    public function insert($escolaridade)
    {

    }

    public function delete($id)
    {

    }

    public function update($escolaridade)
    {

    }
}

