<?php

class Application_Model_DbTable_TermoAditivo extends Zend_Db_Table_Abstract
{

   	protected $_name = 'termo_aditivo';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_TipoTermoAditivo' => array(
            'columns'           => 'tipo_termo_aditivo_id',
            'refTableClass'     => 'Application_Model_DbTable_TipoTermoAditivo',
            'refColumns'        => 'tipo_termo_aditivo_id'
        ),
        'Application_Model_DbTable_Projeto' => array(
            'columns'           => 'projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_Projeto',
            'refColumns'        => 'projeto_id'
        ),
        'Orcamento_ID_Fonte' => array(
            'columns'           => 'orcamento_id_fonte',
            'refTableClass'     => 'Application_Model_DbTable_Orcamento',
            'refColumns'        => 'orcamento_id'
        ),
        'Orcamento_ID_Destino' => array(
            'columns'           => 'orcamento_id_destino',
            'refTableClass'     => 'Application_Model_DbTable_Orcamento',
            'refColumns'        => 'orcamento_id'
        ),

    );
}

