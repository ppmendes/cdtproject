<?php

class Application_Model_DbTable_PerfilUsuarioPermissoes extends Zend_Db_Table_Abstract
{

    protected $_name = 'perfil-usuario-permissoes'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_PerfilUsuario' => array(
            'columns'           => 'perfil_usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_PerfilUsuario',
            'refColumns'        => 'perfil_usuario_id'
        ),
    );

}