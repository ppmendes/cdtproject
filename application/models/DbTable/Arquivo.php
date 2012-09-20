<?php

class Application_Model_DbTable_Arquivo extends Zend_Db_Table_Abstract
{

   	protected $_name = 'arquivo';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_PastaArquivo' => array(
            'columns'           => 'pasta_arquivo_id',
            'refTableClass'     => 'Application_Model_DbTable_PastaArquivo',
            'refColumns'        => 'pasta_arquivo_id'
        ),
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),
    );
}

