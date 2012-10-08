<?php

class Application_Model_InstituicaoGerencia
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_InstituicaoGerencia;
		$instituicaoGerencia = $table->find($id)->current();
		return $instituicaoGerencia;
	}

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_InstituicaoGerencia;
            $instituicaoGerencia = $table->fetchAll();
            foreach($instituicaoGerencia as $item){
                $options[$item['instituicao_gerencia_id']] = $item['nome_instituicao_gerencia'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($instituicaoGerencia)
    {

    }

    public function delete($id)
    {

    }

    public function update($instituicaoGerencia)
    {

    }
}

