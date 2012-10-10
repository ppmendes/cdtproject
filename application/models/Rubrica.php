<?php

class Application_Model_Rubrica
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Rubrica;
        $rubrica = $table->find($id)->current();
        return $rubrica;
    }

    public function insert($rubrica)
    {

    }

    public function delete($id)
    {

    }

    public function update($rubrica)
    {

    }

    public static function getOptions(){
        try{
            $options2 = array();
            $options = array();
            $table = new Application_Model_DbTable_Rubrica();
            $resultado = $table->fetchAll();

            foreach($resultado as $item){
                if(substr_count($item['codigo_rubrica'], '.') == 2)
                {
                    $options2[$item['rubrica_id']] = $item['codigo_rubrica']." - ".$item['descricao'];
                    $options[] = $item['codigo_rubrica']." - ".$item['descricao'];

                }
            }
            return $options;
        } catch(Exception $e){

        }

    }
}