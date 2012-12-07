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
}

