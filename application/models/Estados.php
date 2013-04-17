<?php

class Application_Model_Estados
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Estados;
        $acesso = $table->find($id)->current();
        return $acesso;
    }



    public function insert($estados)
    {

    }

    public function delete($id)
    {

    }

    public function update($estados)
    {

    }

    public static function getOptions($id_estado_form = null){
        try{
            if($id_estado_form==null)
            {
                $options = array();
                $table = new Application_Model_DbTable_Estados();
                $resultado = $table->fetchAll();
                foreach($resultado as $item){
                    $options[$item['estados_id']] = $item['estados_nome'];
                }
                return $options;

            }else{
                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select estados_id, estados_nome from estados where estados_id = $id_estado_form");

                foreach($resultado as $item){
                    $options[$item['estados_id']] = $item['estados_nome'];
                }
                return $options;
            }

        }catch (Exception $e){

        }

    }
}

