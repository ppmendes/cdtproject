<?php

class Application_Model_Orcamento
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Orcamento;
        $orcamento = $table->find($id)->current();
        return $orcamento;
    }

    public function insert($orcamento)
    {

    }

    public function delete($id)
    {

    }

    public function update($orcamento)
    {

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
                ->joinInner(array('d' => 'destino'), 'o.destino_id = d.destino_id', array('d.nome_destino'=>'d.nome_destino'))
                ->joinInner(array('p' => 'projeto'), 'o.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id'));

            $stmt = $select->query();
            $resultado = $stmt->fetchAll();

            foreach($resultado as $item){
                //if(substr_count($item['codigo_rubrica'], '.') == 2)
                //{
                  //  $options2[$item['rubrica_id']] = $item['codigo_rubrica']." - ".$item['descricao'];
                    $options[] = array('label' => $item['r.codigo_rubrica']." -> ".$item['r.descricao'] ." (" .
                                                  $item['d.nome_destino'] . ") (R$" . $item['o.valor_orcamento'] .")" ,
                                                  'id' => $item['o.orcamento_id']);
                }

            return $options;

        }catch(Exception $e){
            echo $e->getMessage();
        }

    }
}
