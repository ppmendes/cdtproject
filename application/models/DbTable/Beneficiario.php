<?php

class Application_Model_DbTable_Beneficiario extends Zend_Db_Table_Abstract
{

   	protected $_name = 'beneficiario';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Pais' => array(
            'columns'           => 'pais_id',
            'refTableClass'     => 'Application_Model_DbTable_Pais',
            'refColumns'        => 'pais_id'
        ),
        'Application_Model_DbTable_Estados' => array(
            'columns'           => 'estados_id',
            'refTableClass'     => 'Application_Model_DbTable_Estados',
            'refColumns'        => 'estados_id'
        ),
        'Application_Model_DbTable_Cidade' => array(
            'columns'           => 'cidade_id',
            'refTableClass'     => 'Application_Model_DbTable_Cidade',
            'refColumns'        => 'cidade_id'
        ),
        'Application_Model_DbTable_Banco' => array(
            'columns'           => 'banco_id',
            'refTableClass'     => 'Application_Model_DbTable_Banco',
            'refColumns'        => 'banco_id'
        ),
        'Application_Model_DbTable_Escolaridade' => array(
            'columns'           => 'escolaridade_id',
            'refTableClass'     => 'Application_Model_DbTable_Escolaridade',
            'refColumns'        => 'escolaridade_id'
        ),
        'Application_Model_DbTable_AreaConhecimento' => array(
            'columns'           => 'area_conhecimento_id',
            'refTableClass'     => 'Application_Model_DbTable_AreaConhecimento',
            'refColumns'        => 'area_conhecimento_id'
        ),
    );
}

