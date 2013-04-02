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
            'columns'           => 'coodenador_projeto',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_Beneficiario' => array(
            'columns'           => 'beneficiario_id',
            'refTableClass'     => 'Application_Model_DbTable_Beneficiario',
            'refColumns'        => 'beneficiario_id'
        ),
        'Application_Model_DbTable_TipoSolicitacao' => array(
            'columns'           => 'tipo_solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_TipoSolicitacao',
            'refColumns'        => 'tipo_solicitacao_id'
        ),
        'Application_Model_DbTable_DiariasPassagens' => array(
            'columns'           => 'diarias_passagens_id',
            'refTableClass'     => 'Application_Model_DbTable_DiariasPassagens',
            'refColumns'        => 'diarias_passagens_id'
        ),
    );
}

