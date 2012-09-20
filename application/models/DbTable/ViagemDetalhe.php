<?php

class Application_Model_DbTable_ViagemDetalhe extends Zend_Db_Table_Abstract
{

    protected $_name = 'viagem_detalhe'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_Solicitacao' => array(
            'columns'           => 'solicitacao_id',
            'refTableClass'     => 'Application_Model_Solicitacao',
            'refColumns'        => 'solicitacao_id'
        ),
    );

}

