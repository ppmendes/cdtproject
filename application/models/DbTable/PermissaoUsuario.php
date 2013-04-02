<?php

class Application_Model_DbTable_PermissaoUsuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'permissao-usuario'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
    );

}