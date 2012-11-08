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
            $where = array('rubrica_id_pai != 1', 'rubrica_id_pai != 2','rubrica_id_pai != 0');
            $resultado = $table->fetchAll($where);
            foreach($resultado as $item){
                    $options[] = array('label' => $item['codigo_rubrica']." - ".$item['descricao'], 'id' => $item['rubrica_id']);
            }
            return $options;
        } catch(Exception $e){
        }

    }
}