<?php

class Application_Model_Banco
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Banco;
		$banco = $table->find($id)->current();
		return $banco;
	}
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Banco();
            $banco = $table->fetchAll();
            foreach($banco as $item){
                $options[$item['banco_id']] = $item['nome_banco'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
    public function insert($banco)
    {

    }

    public function delete($id)
    {

    }

    public function update($banco)
    {

    }
}

