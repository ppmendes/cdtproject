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
        $decimalfilter = new Zend_Filter_DecimalFilter();
        //DIFF orc
        
        $empenho = $data['desembolso']['empenho_id'];
        $tableemp = new Application_Model_DbTable_Empenho();
        $empenhodata = $tableemp->find($empenho)->current();
        //print_r($empenhodata);
        //exit;
        $orcamento = $empenhodata['orcamento_id'];
        $tableorc = new Application_Model_DbTable_Orcamento();
        $orcamentodata = $tableorc->find($orcamento)->current();
        
        $projeto_id = $orcamentodata['projeto_id'];
        //EQUAL orc
                
        $arrayCodigoRubrica = $this->getCodigoRubrica($orcamentodata['rubrica_id']);
        $codigoRubrica = $arrayCodigoRubrica[0]['r.codigo_rubrica'];

        $rubrica = explode(".", $codigoRubrica);

        $data['desembolso']['valor_desembolso'] = $decimalfilter->filter($data['desembolso']['valor_desembolso']);

        $valor = 0.2 * $data['desembolso']['valor_desembolso'];

        unset($data['desembolso']['projeto_id']);
        
        $table->insert($data['desembolso']);
        $desembolso_rel = $this->getLastInsertedId('desembolso');

        if ($rubrica[1] == '36')
        {
            if ($rubrica[2] != '02' && $rubrica[2] != '03' && $rubrica[2] != '07' && $rubrica[2] != '46' && $rubrica[2] != '80')
            {
                $imposto = Array();
                $imposto['desembolso']['desembolso_rel'] = $desembolso_rel;
                $imposto['desembolso']['codigo_documento_habil'] = $data['desembolso']['codigo_documento_habil'];
                $imposto['desembolso']['data_documento_habil'] = $data['desembolso']['data_documento_habil'];
                $imposto['desembolso']['order_dinheiro'] = $data['desembolso']['order_dinheiro'];
                $imposto['desembolso']['data_pagamento'] = $data['desembolso']['data_pagamento'];
                $imposto['desembolso']['valor_desembolso'] = $valor;
                $imposto['desembolso']['empenho_id'] = $data['desembolso']['empenho_id']+1;

                $table->insert($imposto['desembolso']);
            }
        }
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
            10=> 'p.orcamento',
            11=> 'r.codigo_rubrica',
            12=> 'r.descricao',
            13=> 'e.processo_administrativo',
            14=> 'e.descricao_historico'
        );

            $select = $db->select()
            ->from(array('d' => 'desembolso'),array())
            ->where('p.projeto_id = ' . $id . ' AND d.extornado = 0')
            ->joinLeft(array('e'=>'empenho'), 'd.empenho_id = e.empenho_id', array())
            ->joinLeft(array('pe'=>'pre_empenho'), 'e.pre_empenho_id = pe.pre_empenho_id', array())
            ->joinLeft(array('o'=>'orcamento'),'e.orcamento_id = o.orcamento_id',array())
            ->joinLeft(array('p'=>'projeto'), 'o.projeto_id = p.projeto_id', array())
            ->joinLeft(array('r'=>'rubrica'), 'o.rubrica_id = r.rubrica_id', array())
            //->joinLeft(array('r'=>'rubrica'), 'o.rubrica_id = r.rubrica_id', array())
            //->joinLeft(array('dt'=>'destinatario'), 'o.destinatario_id = dt.destinatario_id', array())
            //->group(array('r.rubrica_id', 'dt.destinatario_id'))
            ->columns($colunas);




        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;


        }catch(Exception $e){
            echo $e->getMessage();
        }
    }


    public function selectAllSoma($id)
    {
        try
        {
            $db = Zend_Db_Table::getDefaultAdapter();

            //VER COMO FICA A PARTE DA CONSULTA QUE TRATA DO orcamento_cronograma, POIS PRECISA SOMAR SOMENTE AS PARCELAS DO
            //CRONOGRAMA ORÇAMENTÁRIO QUE NÃO POSSUEM DELETADO = 1

            $resultado = $db->fetchAll("SELECT o.projeto_id, SUM( d.valor_desembolso ), p.orcamento,

                                        (SELECT SUM( valor )
                                         FROM orcamento_cronograma AS oc, orcamento AS orc
                                         WHERE oc.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $id . "
                                         ) AS valor,

                                        (SELECT SUM( valor_orcamento )
                                        FROM orcamento AS orc
                                        WHERE orc.projeto_id = " . $id . " AND orc.deletado = 0
                                        ) AS valor_orcamento,

                                        (SELECT SUM( valor_empenho )
                                         FROM empenho AS e1, orcamento AS orc
                                         WHERE e1.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $id . " AND e1.deletado = 0
                                         ) AS valor_empenho,

                                         (SELECT SUM( pe.valor_pre_empenho )
                                         FROM pre_empenho AS pe, empenho as e1, orcamento as orc
                                         WHERE pe.pre_empenho_id = e1.pre_empenho_id AND e1.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $id . "
                                          AND pe.deletado = 0
                                         ) AS valor_pre_empenho,

                                         (SELECT SUM( valor_recebido )
                                         FROM cronograma_financeiro AS cf
                                         WHERE cf.projeto_id = " . $id . " AND cf.deletado = 0
                                         ) AS valor_recebido

                                         FROM desembolso AS d
                                         LEFT JOIN empenho AS e ON d.empenho_id = e.empenho_id
                                         LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                                         LEFT JOIN projeto as p ON o.projeto_id = p.projeto_id
                                         WHERE o.projeto_id = ". $id . " AND d.extornado = 0");


            return $resultado;

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectSaldoEmpenho($eid)
    {
        try{

            $db = Zend_Db_Table::getDefaultAdapter();

            $colunas = array(
                0 => 'SUM( valor_desembolso )',
            );

            $select = $db->select()
                ->from(array('d' => 'desembolso'),array())
                ->where('d.empenho_id = ?', $eid)
                ->columns($colunas);

            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;


        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectOrcamentoProjeto($pid){

        try{

            $db = Zend_Db_Table::getDefaultAdapter();

            $colunas = array(
                0 => 'orcamento',
            );

            $select = $db->select()
                ->from(array('p' => 'projeto'),array())
                ->where('p.projeto_id = ?', $pid)
                ->columns($colunas);

            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;


        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectTotalTiposRubrica($pid){

        try
        {
            $db = Zend_Db_Table::getDefaultAdapter();

            $despesasCorrentes = $db->fetchAll("SELECT SUM( valor_desembolso ),

                                        (SELECT SUM( valor_empenho )
                                         FROM empenho AS e1, orcamento AS orc, rubrica AS rub
                                         WHERE e1.orcamento_id = orc.orcamento_id AND orc.rubrica_id = rub.rubrica_id AND orc.projeto_id = " . $pid . "
                                         AND rub.codigo_rubrica LIKE '%33390%' AND e1.deletado = 0
                                         ) AS valor_empenho,

                                         (SELECT SUM( pe.valor_pre_empenho )
                                         FROM pre_empenho AS pe, empenho as e1, orcamento as orc, rubrica AS rub
                                         WHERE pe.pre_empenho_id = e1.pre_empenho_id AND orc.rubrica_id = rub.rubrica_id AND
                                         e1.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $pid . " AND rub.codigo_rubrica LIKE '%33390%'
                                          AND pe.deletado = 0
                                         ) AS valor_pre_empenho


                                        FROM desembolso AS d
                                        LEFT JOIN empenho AS e ON d.empenho_id = e.empenho_id
                                        LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                                        LEFT JOIN rubrica AS r ON o.rubrica_id = r.rubrica_id
                                        LEFT JOIN projeto AS p ON o.projeto_id = p.projeto_id
                                        WHERE o.projeto_id = " . $pid . " AND codigo_rubrica LIKE '%33390%' AND d.extornado = 0");

            $despesasCapitais = $db->fetchAll("SELECT SUM( valor_desembolso ),

                                        (SELECT SUM( valor_empenho )
                                         FROM empenho AS e1, orcamento AS orc, rubrica AS rub
                                         WHERE e1.orcamento_id = orc.orcamento_id AND orc.rubrica_id = rub.rubrica_id AND orc.projeto_id = " . $pid . "
                                         AND rub.codigo_rubrica LIKE '%34490%' AND e1.deletado = 0
                                         ) AS valor_empenho,

                                         (SELECT SUM( pe.valor_pre_empenho )
                                         FROM pre_empenho AS pe, empenho as e1, orcamento as orc, rubrica AS rub
                                         WHERE pe.pre_empenho_id = e1.pre_empenho_id AND orc.rubrica_id = rub.rubrica_id AND
                                         e1.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $pid . " AND rub.codigo_rubrica LIKE '%34490%'
                                          AND pe.deletado = 0
                                         ) AS valor_pre_empenho


                                        FROM desembolso AS d
                                        LEFT JOIN empenho AS e ON d.empenho_id = e.empenho_id
                                        LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                                        LEFT JOIN rubrica AS r ON o.rubrica_id = r.rubrica_id
                                        LEFT JOIN projeto AS p ON o.projeto_id = p.projeto_id
                                        WHERE o.projeto_id = " . $pid . " AND codigo_rubrica LIKE '%34490%' AND d.extornado = 0");

            $result = array();
            $result[0] = ($despesasCorrentes[0]['valor_empenho'] + $despesasCorrentes[0]['valor_pre_empenho']) -
                $despesasCorrentes[0]['SUM( valor_desembolso )'];
            $result[1] = ($despesasCapitais[0]['valor_empenho'] + $despesasCapitais[0]['valor_pre_empenho']) -
                $despesasCapitais[0]['SUM( valor_desembolso )'];

            return $result;

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions($pid)
    {

            $options = array();
            $db = Zend_Db_Table::getDefaultAdapter();
            $desembolsoSaldo = $db->fetchAll("SELECT o.rubrica_id, empenho_id, valor_empenho, processo_administrativo, nome,


                                        (SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                                        FROM desembolso AS des
                                        WHERE e.empenho_id = des.empenho_id AND des.extornado = 0
                                        ) AS saldo_empenho


                                        FROM empenho AS e
                                        LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                                        LEFT JOIN beneficiario AS b ON e.beneficiario_id = b.beneficiario_id
                                        LEFT JOIN rubrica AS r ON o.rubrica_id = r.rubrica_id

                                        WHERE o.projeto_id = " . $pid . " AND e.deletado = 0 AND ((SELECT (e.valor_empenho - SUM( des.valor_desembolso ))
                                        FROM desembolso AS des
                                        WHERE e.empenho_id = des.empenho_id AND des.extornado = 0
                                        ) > 0 )");


            $desembolsoSemEmpenho = $db->fetchAll("SELECT orcamento.rubrica_id, processo_administrativo, nome, valor_empenho, empenho.empenho_id, orcamento.projeto_id
                                                  FROM empenho
                                                  LEFT JOIN desembolso ON empenho.empenho_id = desembolso.empenho_id
                                                  LEFT JOIN beneficiario ON empenho.beneficiario_id = beneficiario.beneficiario_id
                                                  LEFT JOIN orcamento ON empenho.orcamento_id = orcamento.orcamento_id
                                                  LEFT JOIN rubrica ON orcamento.rubrica_id = rubrica.rubrica_id
                                                  WHERE desembolso.empenho_id IS NULL AND orcamento.projeto_id = " . $pid . "
                                                   AND empenho.deletado = 0");

            $desembolso = array_merge($desembolsoSaldo, $desembolsoSemEmpenho);

            foreach($desembolso as $item){

            $rubrica_id = $item['rubrica_id'];

                if ($rubrica_id != '44')
                {

                    if (array_key_exists("saldo_empenho", $item) == 1)
                    {
                        $options[$item['empenho_id']] = $item['processo_administrativo'] . " - " . $item['nome'] .
                                              " - Saldo de R$" . $item['saldo_empenho'];
                    }
                    else
                    {
                        $options[$item['empenho_id']] = $item['processo_administrativo'] . " - " . $item['nome'] .
                        " - Saldo de R$" . $item['valor_empenho'];
                    }

                }
            }


            return $options;

    }
    
    public function getCodigoRubrica ($rid)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                         ->from(array('r' => 'rubrica'), array('r.codigo_rubrica' => 'r.codigo_rubrica'))
                         ->where('r.rubrica_id = ?', $rid);

            $stmt = $select->query();
            $resultado = $stmt->fetchAll();

            return $resultado;

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function getLastInsertedId($table){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(" . $table . "_id) FROM " . $table . "");
        return (int)$result;
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


