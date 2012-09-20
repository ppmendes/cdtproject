<?php

class Application_Model_DbTable_Tarefa extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefa'; // nome tabela no banco

     protected $_referenceMap    = array(
         'Application_Model_DbTable_Projeto' => array(
             'columns'           => 'projeto_id',
             'refTableClass'     => 'Application_Model_DbTable_Projeto',
             'refColumns'        => 'projeto_id'
         ),
         'Application_Model_DbTable_Instituicao' => array(
             'columns'           => 'instituicao_id',
             'refTableClass'     => 'Application_Model_DbTable_Instituicao',
             'refColumns'        => 'instituicao_id'
         ),
     );
}

