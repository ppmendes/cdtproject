<?php

class Application_Model_DbTable_BensServicos extends Zend_Db_Table_Abstract
{

   	protected $_name = 'bens_servicos';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Solicitacao' => array(
            'columns'           => 'solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_Solicitacao',
            'refColumns'        => 'solicitacao_id'
        ),
    );
}

