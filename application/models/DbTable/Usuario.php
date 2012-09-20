<?php

class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_PerfilUsuario' => array(
            'columns'           => 'perfil_id',
            'refTableClass'     => 'Application_Model_DbTable_PerfilUsuario',
            'refColumns'        => 'perfil_id'
        ),
        'Application_Model_DbTable_Instituicao' => array(
            'columns'           => 'instituicao_id',
            'refTableClass'     => 'Application_Model_DbTable_Instituicao',
            'refColumns'        => 'instituicao_id'
        ),
    );
}