<?php

class Application_Model_Instituicao
{
   public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Instituicao;
        $instituicao = $table->find($id)->current();
        return $instituicao;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Instituicao;
        $table->insert($data['instituicao']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "instituicao";
        $deletado = true;
        $where = $db->quoteInto('instituicao_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);
    }

    //recebe o id e a data a ser atualizada
    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Instituicao;
        $where = $table->getAdapter()->quoteInto('instituicao_id = ?',$id);

        $table->update($data['instituicao'], $where);
    }

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from('vw_instituicao_projeto_ativo_arquivado',array('instituicao_id','nome','ativo','arquivado','tipo','responsavel','deletado'))
            ->where('deletado = ?', false);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Instituicao();
            $resultado = $table->fetchAll(null,'nome asc');

            foreach($resultado as $item){
                $options[] = array('label' => $item['nome'], 'id' => $item['instituicao_id']);
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function retornaPais()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            // ainda resta apresentar historico de login do usuarios
            $select = $db->select()
                ->from('instituicao',
                array('instituicao_id', 'nome'))
                ->where('pai_id=?',0);

            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        } catch(Exception $e){
            Zend_Registry::get('Log')->log($e->getMessage(),Zend_Log::DEBUG);
        }
    }

    public function paeFilhos($id_pai)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $result=$db->query("CALL sp_recursive_start($id_pai)");
        return $result->fetchAll();
    }

    public function criarTreeview($array)
    {
        $nroElementos=count($array);
        $nivel=1;

        $nome = $array[0]["nome"];
        $id = $array[0]["id"];

        echo '<ul id="red"><li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[0]['nome'].'</a>';


        for($i=1;$i<$nroElementos;$i++)
        {
            $novonivel=$array[$i]['geracao'];

            $nome = $array[$i]['nome'];
            $id = $array[$i]['id'];

            if($novonivel==$nivel)
            {
                echo'</li><li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[$i]['nome'].'</a>';

            }
            elseif($novonivel>$nivel)
            {
                echo'<ul>';
                echo'<li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[$i]['nome'].'</a>';
                $nivel=$novonivel;
            }
            elseif($novonivel<$nivel)
            {
                $nro=$nivel-$novonivel;
                echo'</li>';
                $this->fecharnivel($nro);
                echo'<li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[$i]['nome'].'</a>';
                $nivel=$novonivel;
            }

        }
        $this->fecharnivel($nivel);
    }

    public function fecharnivel($nivel)
    {
        for($i=0;$i<$nivel;$i++)
        {
            echo'</ul></li>';
        }
    }
}
