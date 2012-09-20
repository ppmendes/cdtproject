<?php

class Application_Model_DbTable_TarefaUsuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefa_usuario'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_Acoes' => array(
            'columns'           => 'acoes_id',
            'refTableClass'     => 'Application_Model_DbTable_Acoes',
            'refColumns'        => 'acoes_id'
        ),
    );
}

