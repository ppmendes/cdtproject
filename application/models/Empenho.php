<?php

class Application_Model_Empenho
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Empenho();
        $empenho = $table->find($id)->current();
        return $empenho;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Empenho;
        $decimalfilter = new Zend_Filter_DecimalFilter();
        //DIFF orc
        
        $orcamento = $data['empenhos']['orcamento_id'];
        $tableorc = new Application_Model_DbTable_Orcamento();
        $orcamentodata = $tableorc->find($orcamento)->current();
        
        $projeto_id = $orcamentodata['projeto_id'];
        //EQUAL orc
                
        $arrayCodigoRubrica = $this->getCodigoRubrica($orcamentodata['rubrica_id']);
        $codigoRubrica = $arrayCodigoRubrica[0]['r.codigo_rubrica'];

        $rubrica = explode(".", $codigoRubrica);

        $data['empenhos']['valor_empenho'] = $decimalfilter->filter($data['empenhos']['valor_empenho']);

        $valor = 0.2 * $data['empenhos']['valor_empenho'];
        
        if ($data['empenhos']['pre_empenho_id'] == 1) {
            $data['empenhos']['processo_administrativo'] = "Pre-empenho";
            $data['empenhos']['data'] = "0000-00-00";
            unset($data['empenhos']['beneficiario_id']);
            unset($data['empenhos']['pre_empenho_id']);
        } else {            
            unset($data['empenhos']['pre_empenho_id']);
        }
        
        unset($data['empenhos']['projeto_id']);
        
        $table->insert($data['empenhos']);
        $embolso_rel = $this->getLastInsertedId('empenho');
        //print_r($rubrica); exit;
        if ($rubrica[1] == '36')
        {
            if ($rubrica[2] != '02' && $rubrica[2] != '03' && $rubrica[2] != '07' && $rubrica[2] != '46' && $rubrica[2] != '80')
            {
                $imposto = array();
                $imposto['empenhos'] = $data['empenhos'];
                $imposto['empenhos']['orcamento_id'] = $data['empenhos']['orcamento_id'] + 1;
                $imposto['empenhos']['descricao_historico'] = $data['empenhos']['descricao_historico']." - 20% INSS = R$ ".$valor;;
                $imposto['empenhos']['empenho_rel'] = $embolso_rel;
                $imposto['empenhos']['valor_empenho'] = $valor;

                $table->insert($imposto['empenhos']);
            }
        }
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "empenho";
        $deletado = true;
        $where = $db->quoteInto('empenho_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);
    }

    public function update($data, $id)
    {
        $table = new Application_Model_DbTable_Empenho;
        $where = $table->getAdapter()->quoteInto('empenho_id = ?',$id);

        $table->update($data['empenhos'],$where);
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Empenho;
            $empenho = $table->fetchAll();
            foreach($empenho as $item){
                $options[$item['empenho_id']] = $item['descricao_historico'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function selectAll($id)
    {
        try
        {
        $db = Zend_Db_Table::getDefaultAdapter();
        $datefilter = new Zend_Filter_DateFilter();
        $decimalfilter = new Zend_Filter_DecimalFilter();

        $colunas = array(
            0 => 'e.descricao_historico',
            1 => 'e.data',
            2 => 'b.nome',
            3 => 'p.nome',
            4 => 'e.valor_empenho',
            5 => 'e.numero_parcelas',
            6 => 'e.data_inicio',
            7 => 'e.data_fim',
            8 => 'o.descricao_orcamento',
            9 => 'u.nome',
            10 => 'e.pre_empenho_id',
            11 => 'b.beneficiario_id',
            12 => 'b.tipo_beneficiario_id',
            13 => 'o.projeto_id',
            14 => 'e.empenho_id',
            15 => 'e.orcamento_id',
            16 => 'e.usuario_id',
            17 => 'r.codigo_rubrica',
            18 => 'e.processo_administrativo'

        );

        $select = $db->select()
            ->from(array('e' => 'empenho'),array())
            ->where('p.projeto_id = ' . $id . ' AND e.deletado = 0')
            ->joinLeft(array('b'=>'beneficiario'),'e.beneficiario_id = b.beneficiario_id',array())
            ->joinLeft(array('o'=>'orcamento'),'e.orcamento_id = o.orcamento_id',array())
            ->joinLeft(array('u'=>'usuario'),'e.usuario_id = u.usuario_id',array())
            ->joinLeft(array('p'=>'projeto'), 'o.projeto_id = p.projeto_id', array())
            ->joinLeft(array('r'=>'rubrica'), 'o.rubrica_id = r.rubrica_id', array())
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

            $resultado = $db->fetchAll("SELECT o.projeto_id, SUM( e.valor_empenho ), p.orcamento,

                                        (SELECT SUM( valor_orcamento )
                                        FROM orcamento AS orc
                                        WHERE orc.projeto_id = " . $id . " AND orc.deletado = 0
                                        ) AS valor_orcamento,

                                        (SELECT SUM( valor )
                                         FROM orcamento_cronograma AS oc, orcamento AS orc
                                         WHERE oc.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $id . " AND orc.deletado = 0
                                         ) AS valor,

                                        (SELECT SUM( valor_desembolso )
                                         FROM desembolso AS des, empenho AS emp, orcamento AS orc
                                         WHERE des.empenho_id = emp.empenho_id AND emp.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $id . "
                                          AND des.extornado = 0 AND emp.deletado = 0 AND orc.deletado = 0
                                         ) AS valor_desembolso,

                                         (SELECT SUM( pe.valor_pre_empenho )
                                         FROM pre_empenho AS pe, empenho as e1, orcamento as orc
                                         WHERE pe.pre_empenho_id = e1.pre_empenho_id AND e1.orcamento_id = orc.orcamento_id AND orc.projeto_id = " . $id . "
                                          AND pe.deletado = 0 AND e1.deletado = 0 AND orc.deletado = 0
                                         ) AS valor_pre_empenho,

                                         (SELECT SUM( valor_recebido )
                                         FROM cronograma_financeiro AS cf
                                         WHERE cf.projeto_id = " . $id . " AND cf.deletado = 0
                                         ) AS valor_recebido

                                         FROM empenho AS e
                                         LEFT JOIN pre_empenho AS pe ON e.pre_empenho_id = pe.pre_empenho_id
                                         LEFT JOIN orcamento AS o ON e.orcamento_id = o.orcamento_id
                                         LEFT JOIN projeto as p ON o.projeto_id = p.projeto_id
                                         WHERE o.projeto_id = ". $id . " AND e.deletado = 0 AND o.deletado = 0");


            return $resultado;

        }catch(Exception $e){
            echo $e->getMessage();
        }
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


    public static function getOrcamentosNaoPagos($id)
    {
        $options = array();
        $db = Zend_Db_Table::getDefaultAdapter();
        $orcamentoSaldo = $db->fetchAll("SELECT o.rubrica_id, codigo_rubrica, descricao, nome_destinatario, oc.orcamento_id,


                                        (SELECT (oc.valor - SUM( emp.valor_empenho ))
                                        FROM empenho AS emp
                                        WHERE oc.orcamento_id = emp.orcamento_id AND emp.deletado = 0
                                        ) AS saldo_orcamento


                                        FROM orcamento_cronograma AS oc
                                        LEFT JOIN orcamento AS o ON oc.orcamento_id = o.orcamento_id
                                        LEFT JOIN rubrica AS r ON o.rubrica_id = r.rubrica_id
                                        LEFT JOIN destinatario AS d ON o.destinatario_id = d.destinatario_id

                                        WHERE o.projeto_id = " . $id . " AND oc.deletado = 0 AND o.deletado = 0 AND
                                        ((SELECT (oc.valor - SUM( emp.valor_empenho ))
                                        FROM empenho AS emp
                                        WHERE oc.orcamento_id = emp.orcamento_id AND emp.deletado = 0
                                        ) > 0 )");


        $orcamentoSemEmpenho = $db->fetchAll("SELECT orcamento.rubrica_id, codigo_rubrica, descricao, nome_destinatario, valor, valor_orcamento, orcamento.orcamento_id, orcamento.projeto_id
                                                  FROM orcamento_cronograma
                                                  LEFT JOIN orcamento ON orcamento_cronograma.orcamento_id = orcamento.orcamento_id
                                                  LEFT JOIN empenho ON orcamento.orcamento_id = empenho.orcamento_id
                                                  LEFT JOIN rubrica ON orcamento.rubrica_id = rubrica.rubrica_id
                                                  LEFT JOIN destinatario ON orcamento.destinatario_id = destinatario.destinatario_id
                                                  WHERE empenho.orcamento_id IS NULL AND orcamento.projeto_id = " . $id . " AND orcamento.deletado = 0
                                                  AND orcamento_cronograma.deletado = 0");

        $orcamento = array_merge($orcamentoSaldo, $orcamentoSemEmpenho);

        foreach($orcamento as $item){

            $rubrica_id = $item['rubrica_id'];

            if ( $rubrica_id != '44')
            {

                if (array_key_exists("saldo_orcamento", $item) == 1)
                {

                    $options[$item['orcamento_id']] = $item['codigo_rubrica'] . " : " . $item['descricao'] .
                    " - " . $item['nome_destinatario'] . " / Saldo de R$" . $item['saldo_orcamento'];
                }
                else
                {
                    $options[$item['orcamento_id']] = $item['codigo_rubrica'] . " : " . $item['descricao'] .
                    " - " . $item['nome_destinatario'] . " / Saldo de R$" . $item['valor'];
                }

            }
        }

        return $options;

        }


}

        /* Esta parte é usada quando o módulo inteiro é carregado, podendo ser 40 mil registros.
        $a = $stmt->fetchAll();

        echo "<pre>";
        print_r($a);
        exit;
        echo "</pre>";

        $data = array();

        while ($row = $stmt->fetch(Zend_Db::FETCH_NUM)) {
            $beneficiario_id = $row[11];
            $tipo_beneficiario_id = $row[12];
            unset($row[11]);
            unset($row[12]);
            unset($row[13]);

            //formatando data
            $row[1] = $datefilter->filter($row[1]);
            $row[6] = $datefilter->filter($row[6]);
            $row[7] = $datefilter->filter($row[7]);

            //formatando decimal
            $row[4] = $decimalfilter->filter($row[4]);

            if($tipo_beneficiario_id == 2){
                $row[2] = '<a href="beneficiarios/detalhespf/beneficiario_id/'.$beneficiario_id.'">'.$row[2].'</a>';
            } else{
                $row[2] = '<a href="beneficiarios/detalhespj/beneficiario_id/'.$beneficiario_id.'">'.$row[2].'</a>';
            }

            $data[] = $row;


        }
        echo "<pre>";
        print_r($row);
        exit;
        echo "</pre>";

        return $data;
    }       */


