<?php

class Application_Model_DbTable_InstituicaoGerencia extends Zend_Db_Table_Abstract
{

   	protected $_name = 'instituicao_gerencia';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_InstituicaoGerencia' => array(
            'columns'           => 'instituicao_gerencia_id',
            'refTableClass'     => 'Application_Model_DbTable_InstituicaoGerencia',
            'refColumns'        => 'instituicao_gerencia_id'
        )
    );
}

