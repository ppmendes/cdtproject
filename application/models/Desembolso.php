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
    public function selectAll($id)
    {
        try{

        $db = Zend_Db_Table::getDefaultAdapter();

        $colunas = array(
            0 => 'd.desembolso_id',
            1 => 'd.desembolso_rel',
            2 => 'd.codigo_documento_habil',
            3 => 'd.data_documento_habil',
            4 => 'd.order_dinheiro',
            5 => 'd.data_pagamento',
            6 => 'd.valor_desembolso',
            7 => 'd.empenho_id',
            8 => 'd.extornado',
            9 => 'o.projeto_id',
            10=> 'SUM( d.valor_desembolso )',
            11=> 'SUM( e.valor_empenho )',
            12=> 'SUM( pe.valor_pre_empenho )',
            13=> 'SUM( o.valor_orcamento )',
            14=> 'p.orcamento',
            15=> 'dt.destinatario_id',

        );

            $select = $db->select()
            ->from(array('d' => 'desembolso'),array())
            ->where('p.projeto_id = ?', $id)
            ->joinLeft(array('e'=>'empenho'), 'd.empenho_id = e.empenho_id', array())
            ->joinLeft(array('pe'=>'pre_empenho'), 'e.pre_empenho_id = pe.pre_empenho_id', array())
            ->joinLeft(array('o'=>'orcamento'),'e.orcamento_id = o.orcamento_id',array())
            ->joinLeft(array('p'=>'projeto'), 'o.projeto_id = p.projeto_id', array())
            ->joinLeft(array('r'=>'rubrica'), 'o.rubrica_id = r.rubrica_id', array())
            ->joinLeft(array('dt'=>'destinatario'), 'o.destinatario_id = dt.destinatario_id', array())
            ->group(array('r.rubrica_id', 'dt.destinatario_id'))
            ->columns($colunas);


        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}



        /*while ($row = $stmt->fetch(Zend_Db::FETCH_NUM)) {
            $extornado = $row[8];
            $desembolso_id = $row[9];
            $empenho_id = $row[10];
            unset($row[10]);
            unset($row[9]);
                $row[0] = '<a href="/desembolso/detalhes/desembolso_id/'.$desembolso_id.'">'.$row[0].'</a>';
                $row[7] = '<a href="/empenhos/detalhes/empenho_id/'.$empenho_id.'">'.$row[7].'</a>';
            if($extornado == 1){
                $row[8] = 'Sim';
            } else{
                $row[8] = 'Não';
            }

            $data[] = $row;
        }

        return $data;
    }
}   */


