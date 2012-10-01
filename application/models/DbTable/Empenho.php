<?php

class Application_Model_DbTable_Empenho extends Zend_Db_Table_Abstract
{

    protected $_name = 'empenho';
    protected $_referenceMap    = array(
        'Application_Model_DbTable_Beneficiario' => array(
            'columns'           => 'beneficiario_id',
            'refTableClass'     => 'Application_Model_DbTable_Beneficiario',
            'refColumns'        => 'beneficiario_id'
        ),
        'Application_Model_DbTable_Projeto' => array(
            'columns'           => 'projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_Projeto',
            'refColumns'        => 'projeto_id'
        ),
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),
        'Application_Model_DbTable_Orcamento' => array(
            'columns'           => 'orcamento_id',
            'refTableClass'     => 'Application_Model_DbTable_Orcamento',
            'refColumns'        => 'orcamento_id'
        ),
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_PreEmpenho' => array(
            'columns'           => 'pre_empenho_id',
            'refTableClass'     => 'Application_Model_DbTable_PreEmpenho',
            'refColumns'        => 'pre_empenho_id'
        ),
    );
}