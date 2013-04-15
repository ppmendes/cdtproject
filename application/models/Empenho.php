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
            17 => 'r.codigo_rubrica'

        );

        $select = $db->select()
            ->from(array('e' => 'empenho'),array())
            ->where('p.projeto_id = ?', $id)
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


