<?php

class Application_Model_DbTable_ArquivoUsuarioAcesso extends Zend_Db_Table_Abstract
{

   	protected $_name = 'arquivo_usuario_acesso';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Arquivo' => array(
            'columns'           => 'arquivo_id',
            'refTableClass'     => 'Application_Model_DbTable_Arquivo',
            'refColumns'        => 'arquivo_id'
        ),
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_Acoes' => array(
            'columns'           => 'acoes_id',
            'refTableClass'     => 'Application_Model_DbTable_Acoes',
            'refColumns'        => 'acoes_id'
        ),
    );
}

