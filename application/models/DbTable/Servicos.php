<?php

class Application_Model_DbTable_Servicos extends Zend_Db_Table_Abstract
{

    protected $_name = 'servicos'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Solicitacao' => array(
            'columns'           => 'solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_Solicitacao',
            'refColumns'        => 'solicitacao_id'
        ),
    );
}

