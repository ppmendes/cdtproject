<?php

class Application_Model_DbTable_CompanhiasSugeridas extends Zend_Db_Table_Abstract
{

    protected $_name = 'companhias_sugeridas';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Solicitacao' => array(
            'columns'           => 'solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_Solicitacao',
            'refColumns'        => 'solicitacao_id'
        ),
        'Application_Model_DbTable_Companhia' => array(
            'columns'           => 'companhia_id',
            'refTableClass'     => 'Application_Model_DbTable_Companhia',
            'refColumns'        => 'companhia_id'
        ),
    );
}