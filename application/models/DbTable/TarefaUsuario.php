<?php

class Application_Model_DbTable_TarefaUsuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefa_usuario'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Tarefa_id' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Usuario_id' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
    );
}

