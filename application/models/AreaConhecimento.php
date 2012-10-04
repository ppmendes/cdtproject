<?php

class Application_Model_AreaConhecimento
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_AreaConhecimento;
		$areaConhecimento = $table->find($id)->current();
		return $areaConhecimento;
	}
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_AreaConhecimento;
            $areaConhecimento = $table->fetchAll();
            foreach($areaConhecimento as $item){
                $options[$item['area_conhecimento_id']] = $item['nome_area'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
    public function insert($areaConhecimento)
    {

    }

    public function delete($id)
    {

    }

    public function update($areaConhecimento)
    {

    }
}

