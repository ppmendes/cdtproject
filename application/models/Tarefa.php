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

    public function selectAll($idusuario)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $result=$db->fetchAll("call SP_tarefas_tree($idusuario)");

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectAllporprojeto($idusuario,$idprojeto)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $result=$db->fetchAll("call SP_tarefas_projetos_tree($idusuario,$idprojeto)");

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

    public static function getTarefasByIdProjeto($id_projeto_form=null){
        try{
           if($id_projeto_form!=null)
           {

               $db = Zend_Db_Table::getDefaultAdapter();
               $resultado = $db->fetchAll("select tarefa_id, nome from tarefa where projeto_id = $id_projeto_form");
               $options = array(''=>'Nenhum');

               foreach($resultado as $item){
                   $options[$item['tarefa_id']] = $item['nome'];
               }

               return $options;
           }else
           {
               $options=array();
               return $options;
           }
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
            if($id_projeto_form == null || $id_projeto_form == "")
            {
                $options = array('0'=>'Nenhum');
                /*$table = new Application_Model_DbTable_Tarefa();
                $resultado = $table->fetchAll();


                foreach($resultado as $item){

                   $options[$item['tarefa_id']] = $item['nome'];
                }*/
                return $options;
            }
            else
            {
                $optionNenhum = array('0' =>'Nenhum');

                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select tarefa_id, nome from tarefa where projeto_id = $id_projeto_form");


                foreach($resultado as $item){

                    $options[$item['tarefa_id']] = $item['nome'];
                }
                $result = $optionNenhum + $options;
                return $result;
            }
        } catch(Exception $e){

        }

    }

    public static function getOptions3($id_projeto_form = null,$id_tarefa_form = null){

        try{
            if($id_projeto_form == null || $id_tarefa_form == null)
            {
                $options = array();
                return $options;
            }
            else
            {

                $options = array();
                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado_dep = $db->fetchAll("select tarefa_id from tarefa where tarefa_id in (select TD.tarefa_dependente from tarefa as T inner join tarefas_dependentes as TD on T.tarefa_id=TD.tarefa_id where T.tarefa_id=$id_tarefa_form)");

                $id=array();
                if($resultado_dep !=array()){
                    foreach($resultado_dep as $item_dep)
                    {
                        $id[]=$item_dep['tarefa_id'];
                    }
                    $id=implode(',',$id);
                    $resultado = $db->fetchAll("select tarefa_id, nome from tarefa where projeto_id = $id_projeto_form and tarefa_id not in ($id)");

                }
                else{
                    $resultado = $db->fetchAll("select tarefa_id, nome from tarefa where projeto_id = $id_projeto_form ");

                }
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
        if($array!=null)
        {
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

