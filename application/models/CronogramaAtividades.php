<?php

class Application_Model_CronogramaAtividades
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_CronogramaAtividades();
        $cronograma_atividades = $table->find($id)->current();
        return $cronograma_atividades;
    }

    public function insert($cronograma_atividades)
    {

    }

    public function delete($id)
    {

    }

    public function update($cronograma_atividades)
    {

    }
}

