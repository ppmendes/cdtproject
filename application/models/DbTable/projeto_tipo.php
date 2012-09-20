<?php

class Application_Model_DbTable_Projeto_Tipo extends Zend_Db_Table_Abstract
{

    protected $_name = 'projeto_tipo';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_FasesDesenvolvimentos' => array(
            'columns'           => 'fases_desenvolvimentos_id',
            'refTableClass'     => 'Application_Model_DbTable_FasesDesenvolvimentos',
            'refColumns'        => 'id'
        ),
    );
}
