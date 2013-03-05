<?php
class Application_Model_DbTable_TarefasDependentes extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefas_dependentes'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Tarefa' => array(
        'columns'           => 'tarefa_id',
        'refTableClass'     => 'Application_Model_DbTable_Tarefa',
        'refColumns'        => 'tarefa_id'
        ),
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_dependente',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
            ),
    );
}

