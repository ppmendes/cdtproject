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
    );
}