<?php

class Application_Model_DbTable_ViagemDetalhe extends Zend_Db_Table_Abstract
{

    protected $_name = 'viagem_detalhe'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_CategoriaFinanciador' => array(
            'columns'           => 'categoria_financiador_id',
            'refTableClass'     => 'Application_Model_DbTable_CategoriaFinanciador',
            'refColumns'        => 'categoria_financiador_id'
        ),
    );

}

