<?php

class Application_Model_Orcamento
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Orcamento;
        $orcamento = $table->find($id)->current();
        return $orcamento;
    }

    public function insert($data)
    {
        $decimalfilter = new Zend_Filter_DecimalFilter();
        $table = new Application_Model_DbTable_Orcamento();

        $projeto_id = $data['orcamento']['projeto_id'];
        $destinatario_id = $data['orcamento']['destinatario_id'];

        $arrayCodigoRubrica = $this->getCodigoRubrica($data['orcamento']['rubrica_id']);

        $codigoRubrica = $arrayCodigoRubrica[0]['r.codigo_rubrica'];

        $rubrica = explode(".", $codigoRubrica);

        $data['orcamento']['valor_orcamento'] = $decimalfilter->filter($data['orcamento']['valor_orcamento']);

        $valor = 0.2 * $data['orcamento']['valor_orcamento'];

        unset($data['orcamento']['rubrica']);
        unset($data['orcamento']['saldo']);


        $table->insert($data['orcamento']);
        $orcamento_rel = $this->getLastInsertedId('orcamento');

        if ($rubrica[1] == '36')
        {
            if ($rubrica[2] != '02' && $rubrica[2] != '03' && $rubrica[2] != '07' && $rubrica[2] != '46' && $rubrica[2] != '80')
            {
                $imposto = Array();
                $imposto['orcamento']['projeto_id'] = $projeto_id;
                $imposto['orcamento']['rubrica_id'] = 44;
                $imposto['orcamento']['orcamento_rel'] = $orcamento_rel;
                $imposto['orcamento']['descricao_orcamento'] = "Obrigações tributárias e contributivas referentes à pagamento de
                pessoa física";
                $imposto['orcamento']['objetivo_orcamento'] = "Execução do Projeto";
                $imposto['orcamento']['valor_orcamento'] = $valor;
                $imposto['orcamento']['destinatario_id'] = $destinatario_id;

                $table->insert($imposto['orcamento']);
            }
        }
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "orcamento";
        $deletado = true;
        $where = $db->quoteInto('orcamento_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);
    }

    public function update($data, $id)
    {
        $decimalfilter = new Zend_Filter_DecimalFilter();
        $data['orcamento']['valor'] = $decimalfilter->filter($data['orcamento']['valor']);
        unset($data['orcamento']['rubrica']);
        unset($data['orcamento']['saldo']);

        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "orcamento";
        $where = $db->quoteInto('orcamento_id = ?', $id);
        $db->update($table, $data['orcamento'],$where);
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Orcamento();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['orcamento_id']] = $item['descricao_orcamento'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public static function getCodigoDescricaoRubricaValorOrcamentoNomeDestino($id){
        try{
            $options = array();
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('o' => 'orcamento'), array('o.orcamento_id'=>'o.orcamento_id', 'o.valor_orcamento'=>'o.valor_orcamento', 'r.rubrica_id' => 'r.rubrica_id'))
                ->where('p.projeto_id = ' . $id . ' AND o.deletado = 0')
                ->joinInner(array('r' => 'rubrica'), 'o.rubrica_id = r.rubrica_id', array('r.codigo_rubrica'=>'r.codigo_rubrica', 'r.descricao'=>'r.descricao'))
                ->joinInner(array('d' => 'destinatario'), 'o.destinatario_id = d.destinatario_id', array('d.nome_destinatario'=>'d.nome_destinatario'))
                ->joinInner(array('p' => 'projeto'), 'o.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id'));

            $stmt = $select->query();
            $resultado = $stmt->fetchAll();

            foreach($resultado as $item){
                //if(substr_count($item['codigo_rubrica'], '.') == 2)
                //{
                  //  $options2[$item['rubrica_id']] = $item['codigo_rubrica']." - ".$item['descricao'];
                    $options[] = array('label' => $item['r.codigo_rubrica']." -> ".$item['r.descricao'] ." (" .
                                                  $item['d.nome_destinatario'] . ") (R$" . $item['o.valor_orcamento'] .")" ,
                                                  'id' => $item['o.orcamento_id']);
                }

            return $options;

        }catch(Exception $e){
            echo $e->getMessage();
        }

    }

    public function selectAll($id)

    {

        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $resultado = $db->fetchAll("SELECT o.orcamento_id, o.rubrica_id, SUM( o.valor_orcamento ) , o.destinatario_id,
                                        o.projeto_id, dt.nome_destinatario, r.codigo_rubrica, r.descricao,

                                        (SELECT SUM( valor_recebido )
                                         FROM cronograma_financeiro AS cf
                                         WHERE cf.projeto_id = " . $id . " AND cf.deletado = 0
                                         ) AS valor_recebido,

                                         (SELECT SUM( valor )
                                         FROM orcamento_cronograma AS oc
                                         WHERE oc.orcamento_id = o.orcamento_id AND oc.deletado = 0
                                         ) AS valor,

                                        (SELECT SUM( valor_empenho )
                                         FROM empenho AS e
                                         WHERE e.orcamento_id = o.orcamento_id AND e.deletado = 0
                                         ) AS valor_empenho,

                                         (SELECT SUM( pe.valor_pre_empenho )
                                         FROM pre_empenho AS pe
                                         WHERE pe.projeto_id = " . $id . " AND pe.orcamento_id = o.orcamento_id AND pe.deletado = 0
                                         ) AS valor_pre_empenho,

                                         (SELECT SUM( d.valor_desembolso )
                                         FROM desembolso AS d
                                         LEFT JOIN empenho AS e3 ON d.empenho_id = e3.empenho_id
                                         WHERE e3.orcamento_id = o.orcamento_id AND d.extornado = 0 AND e3.deletado = 0
                                         ) AS valor_desembolso

                                         FROM orcamento AS o
                                         LEFT JOIN destinatario AS dt ON o.destinatario_id = dt.destinatario_id
                                         LEFT JOIN rubrica AS r ON o.rubrica_id = r.rubrica_id
                                         LEFT JOIN projeto as p ON o.projeto_id = p.projeto_id
                                         WHERE o.projeto_id = " . $id . " AND o.deletado = 0
                                         GROUP BY o.rubrica_id, o.destinatario_id, o.orcamento_id
                                         ORDER BY o.data_registro_orcamento");




//            echo "<pre>";
//
//            print_r($resultado);
//            exit;

            return $resultado;

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function calculaTotal($orcamento)
    {
        $total = 0;
        for($i=0 ; $i<sizeOf($orcamento) ; $i++)
        {

            $total = $total + ($orcamento[$i]['SUM( o.valor_orcamento )']);
        }

        return $total;
    }

    public function getOrcamentoProjeto ($pid) {
        try{
            $options = array();
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('p' => 'projeto'), array('p.orcamento' => 'p.orcamento'))
                ->where('p.projeto_id = ?' , $pid);

            $stmt = $select->query();
            $resultado = $stmt->fetchAll();


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

    public function saldoOrcamentoDisponibilizado ($id) {

        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $resultado = $db->fetchAll("SELECT SUM( valor ),

                                      (SELECT SUM( valor_empenho )
                                      FROM empenho AS e
                                      WHERE e.orcamento_id = oc.orcamento_id AND e.deletado = 0)
                                      AS valor_empenho

                                      FROM orcamento_cronograma AS oc
                                      WHERE oc.orcamento_id = " . $id . ";");

            $saldo = $resultado[0]['SUM( valor )'] - $resultado[0]['valor_empenho'];

            return $saldo;

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

}
