<?php
class Application_Model_DbTable_RubricaAssociadaTarefa extends Zend_Db_Table_Abstract
{

    protected $_name = 'rubrica_associada_tarefa'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),
        'Application_Model_DbTable_Rubrica' => array(
            'columns'           => 'rubrica_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubrica',
            'refColumns'        => 'rubrica_id'
        ),
    );
}

