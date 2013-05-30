<?php

class Application_Model_DbTable_ProjetoUsuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'projeto_usuario'; // nome tabela no banco

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
    );
}

