<?php

class Application_Model_DbTable_TarefaSolicitacao extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefa_solicitacao'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),
        'Application_Model_DbTable_Solicitacao' => array(
            'columns'           => 'solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_Solicitacao',
            'refColumns'        => 'solicitacao_id'
        ),
    );
}

