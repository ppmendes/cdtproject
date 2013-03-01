<?php

class Application_Model_Tarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Tarefa;
        $tarefa = $table->find($id)->current();
        return $tarefa;
    }

    public function insert($data)
    {

        $table = new Application_Model_DbTable_Tarefa;
        $table->insert($data['tarefas']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "tarefa";
        $deletado = true;
        $where = $db->quoteInto('tarefa_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Tarefa;
        $where = $table->getAdapter()->quoteInto('tarefa_id = ?',$id);

        $table->update($data['tarefas'],$where);
    }
    public function getLastInsertedId(){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(tarefa_id) FROM tarefa");
        return (int)$result;
    }

    public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('t' => 'tarefa'))
                ->where('t.deletado = ?', false)
                ->joinLeft(array('us' => 'usuario'), 't.criador = us.usuario_id',array('us.usuario_id'=>'us.usuario_id','us.username'=>'us.username'))
                ->joinLeft(array('pr' => 'projeto'), 't.projeto_id = pr.projeto_id',array('pr.projeto_id'=>'pr.projeto_id','pr.nome'=>'pr.nome'));
//                ->joinLeft(array('ct' => 'usuario'), 'p.coordenador_tecnico = ct.usuario_id',array('ct.usuario_id'=>'ct.usuario_id','ct.nome'=>'ct.nome','ct.sobrenome'=>'ct.sobrenome'))
//                ->joinLeft(array('ga' => 'instituicao_gerencia'), 'p.instituicao_gerencia_id = ga.instituicao_gerencia_id',array(
//                'ga.instituicao_gerencia_id'=>'ga.instituicao_gerencia_id','ga.nome_instituicao_gerencia'=>'ga.nome_instituicao_gerencia'));
            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Projeto();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['projeto_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public static function getOptions2(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Tarefa();
            $resultado = $table->fetchAll();

            foreach($resultado as $item){
                $options[] = array('label' => $item['nome'], 'id' => $item['tarefa_id']);
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public static function getOptions1($id_projeto_form = null){

        try{
            if($id_projeto_form == null)
            {
                $options = array(''=>'Nenhum');
                $table = new Application_Model_DbTable_Tarefa();
                $resultado = $table->fetchAll();


                foreach($resultado as $item){

                   $options[$item['tarefa_id']] = $item['nome'];
                }
                return $options;
            }
            else
            {
                $options = array(''=>'Nenhum');

                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select tarefa_id, nome from tarefa where projeto_id = $id_projeto_form");


                foreach($resultado as $item){

                    $options[$item['tarefa_id']] = $item['nome'];
                }
                return $options;
            }
        } catch(Exception $e){

        }

    }

    public function retornaTarefa()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            // ainda resta apresentar historico de login do usuarios
            $select = $db->select()
                ->from('tarefa',
                array('tarefa_id', 'nome'))
                ->where('tarefa_id_pai=?',0);

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
}

