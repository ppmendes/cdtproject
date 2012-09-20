<?php

class Application_Model_DbTable_Solicitacao extends Zend_Db_Table_Abstract
{

    protected $_name = 'solicitacao'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Projeto' => array(
            'columns'           => 'projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_Projeto',
            'refColumns'        => 'projeto_id'
        ),
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_Beneficiario' => array(
            'columns'           => 'beneficiario_id',
            'refTableClass'     => 'Application_Model_DbTable_Beneficiario',
            'refColumns'        => 'beneficiario_id'
        ),
        'Application_Model_DbTable_EstadoSolicitacao' => array(
            'columns'           => 'estado_solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_EstadoSolicitacao',
            'refColumns'        => 'estado_solicitacao_id'
        ),
        'Application_Model_DbTable_Rubrica' => array(
            'columns'           => 'rubrica_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubrica',
            'refColumns'        => 'rubrica_id'
        ),
    );
}

