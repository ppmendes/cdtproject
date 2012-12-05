<?php

class Application_Model_Desembolso
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Desembolso;
        $desembolso = $table->find($id)->current();
        return $desembolso;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Desembolso;
        $table->insert($data['desembolso']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "desembolso";
        $extornado = true;
        $where = $db->quoteInto('desembolso_id = ?', $id);
        $data = array('extornado' => $extornado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Desembolso;
        $where = $table->getAdapter()->quoteInto('desembolso_id = ?',$id);

        $table->update($data['desembolso'],$where);
    }

//    public function selectAll()
//    {
//        $db = Zend_Db_Table::getDefaultAdapter();
//
//        $select = $db->select()
//            ->from(array('d' => 'desembolso'))
//            ->joinLeft(array('e' => 'empenho'), 'd.empenho_id = e.empenho_id',array('e.descricao_historico'=>'e.descricao_historico'));
//        $stmt = $select->query();
//
//        $result = $stmt->fetchAll(Zend_Db::FETCH_NUM);
//
//        return $result;
//    }
    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $colunas = array(
            0 => 'd.desembolso_rel',
            1 => 'd.codigo_documento_habil',
            2 => 'd.data_documento_habil',
            3 => 'd.order_dinheiro',
            4 => 'd.data_pagamento',
            5 => 'd.valor_desembolso',
            6 => 'd.extornado',
            7 => 'd.desembolso_id',
            8 => 'd.empenho_id',
        );

        $select = $db->select()
            ->from(array('d' => 'desembolso'),array())
            ->columns($colunas);


        $stmt = $select->query();

        while ($row = $stmt->fetch(Zend_Db::FETCH_NUM)) {

            $desembolso_id = $row[7];
            $empenho_id = $row[8];
            //unset($row[7]);
            //unset($row[8]);
                $row[0] = '<a href="/desembolso/detalhes/desembolso_id/'.$desembolso_id.'">'.$row[0].'</a>';
                $row[2] = '<a href="/empenhos/detalhes/empenho_id/'.$empenho_id.'">'.$row[2].'</a>';


            $data[] = $row;
        }

        return $data;
    }
}


