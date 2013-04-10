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
        $data['orcamento']['valor_orcamento'] = $decimalfilter->filter($data['orcamento']['valor_orcamento']);
        unset($data['orcamento']['rubrica']);
        unset($data['orcamento']['saldo']);

        $table = new Application_Model_DbTable_Orcamento();
        $table->insert($data['orcamento']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "orcamento";
        $where = $db->quoteInto('orcamento_id = ?', $id);
        $db->delete($table, $where);
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
                ->where('p.projeto_id = ?' , $id)
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

                                        (SELECT SUM( valor_empenho )
                                         FROM empenho AS e
                                         WHERE e.orcamento_id = o.orcamento_id
                                         ) AS valor_empenho,

                                         (SELECT SUM( pe.valor_pre_empenho )
                                         FROM empenho AS e2
                                         LEFT JOIN pre_empenho AS pe ON e2.pre_empenho_id = pe.pre_empenho_id
                                         WHERE e2.orcamento_id = o.orcamento_id
                                         ) AS valor_pre_empenho,

                                         (SELECT SUM( d.valor_desembolso )
                                         FROM desembolso AS d
                                         LEFT JOIN empenho AS e3 ON d.empenho_id = e3.empenho_id
                                         WHERE e3.orcamento_id = o.orcamento_id
                                         ) AS valor_desembolso

                                         FROM orcamento AS o
                                         LEFT JOIN destinatario AS dt ON o.destinatario_id = dt.destinatario_id
                                         LEFT JOIN rubrica AS r ON o.rubrica_id = r.rubrica_id
                                         WHERE o.projeto_id = ". $id . "
                                         GROUP BY o.rubrica_id, o.destinatario_id
                                         ORDER BY o.data_registro_orcamento");




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

}
