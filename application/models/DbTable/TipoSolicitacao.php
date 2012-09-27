<?php

class Application_Model_DbTable_TipoSolicitacao extends Zend_Db_Table_Abstract
{

    protected $_name = 'tipo_solicitacao'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Rubrica' => array(
            'columns'           => 'rubrica_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubrica',
            'refColumns'        => 'rubrica_id'
        ),

    );
}