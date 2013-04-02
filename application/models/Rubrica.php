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

    // geoptions que coleta as rubrica gerais com id pai = 1
    public static function getOptions2(){
        try{
                $options=array();
                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("SELECT rubrica_id, descricao FROM rubrica r where rubrica_id_pai in (1,2)");

                foreach($resultado as $item){

                    $options[$item['rubrica_id']] = $item['descricao'];
                }
                return $options;

        } catch(Exception $e){

        }

    }
}