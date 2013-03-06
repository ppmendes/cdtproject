<?php
class Application_Model_UsuariosAssociadosTarefa
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_UsuariosAssociadosTarefa();
        $usuario_associado_tarefa = $table->find($id)->current();
        return $usuario_associado_tarefa;
    }
    public function insert($data)
    {
        $table = new Application_Model_DbTable_UsuariosAssociadosTarefa();
        $table->insert($data);
    }

    public function delete($id)
    {
        $table = new Application_Model_DbTable_UsuariosAssociadosTarefa();
        $where = $table->getAdapter()->quoteInto('tarefa_id = ?',$id);
        $table->delete($where);
    }

    public function update($id)
    {

    }

    public static function getOptions($id_tarefa_form = null){

        try{
            if($id_tarefa_form != null)
            {
                $options =array();
                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select U.nome, U.usuario_id, UAT.porcentagem from Usuario as U inner join usuarios_associados_tarefa as UAT on U.usuario_id=UAT.usuario_id where UAT.tarefa_id=$id_tarefa_form");
                foreach($resultado as $item){
                    $options[$item['usuario_id'].'|'.$item['porcentagem']] = $item['nome'].' ['.$item['porcentagem'].'%]';
                }
                return $options;
            }
            else
            {
                $options = array();
                return $options;
            }
        } catch(Exception $e){

        }

    }
}