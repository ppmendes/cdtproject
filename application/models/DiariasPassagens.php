<?php

class Application_Model_DiariasPassagens
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DiariasPassagens();
        $diarias_passagens = $table->find($id)->current();
        return $diarias_passagens;
    }

    public function insert($diarias_passagens)
    {

    }

    public function delete($id)
    {

    }

    public function update($diarias_passagens)
    {

    }
}

