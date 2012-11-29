<?php

class Application_Model_Empenho
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Empenho();
        $empenho = $table->find($id)->current();
        return $empenho;
    }

    public function insert($empenho)
    {

    }

    public function delete($id)
    {

    }

    public function update($empenho)
    {

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

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

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
        );

        $select = $db->select()
            ->from(array('e' => 'empenho'),array())
            ->joinLeft(array('b'=>'beneficiario'),'e.beneficiario_id = b.beneficiario_id',array())
            ->joinLeft(array('p'=>'projeto'),'e.projeto_id = p.projeto_id',array())
            ->joinLeft(array('o'=>'orcamento'),'e.orcamento_id = o.orcamento_id',array())
            ->joinLeft(array('u'=>'usuario'),'e.usuario_id = u.usuario_id',array())
            ->columns($colunas);


        $stmt = $select->query();

        while ($row = $stmt->fetch(Zend_Db::FETCH_NUM)) {
            $beneficiario_id = $row[11];
            $tipo_beneficiario_id = $row[12];
            unset($row[11]);
            unset($row[12]);
            if($tipo_beneficiario_id == 1){
                $row[2] = '<a href="beneficiarios/detalhespf/beneficiario_id/'.$beneficiario_id.'">'.$row[2].'</a>';
            } else{
                $row[2] = '<a href="beneficiarios/detalhespj/beneficiario_id/'.$beneficiario_id.'">'.$row[2].'</a>';
            }

            $data[] = $row;
        }

        return $data;
    }
}

