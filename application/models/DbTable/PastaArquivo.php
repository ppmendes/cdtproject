<?php

class Application_Model_DbTable_PastaArquivo extends Zend_Db_Table_Abstract
{

    protected $_name = 'pasta_arquivo';

//'Application_Model_DbTable_EstadoProjeto' => array(

//Chave estrangeira na tabela projeto
//'columns'           => 'estado_projeto_id',

//nome classe relacionada
//'refTableClass'     => 'Application_Model_DbTable_EstadoProjeto',

//chave primaria da tabela relacionada
//'refColumns'        => 'estado_projeto_id'



    protected $_referenceMap    = array(

        'Application_Model_DbTable_Projeto' => array(
            'columns'           => 'projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_Projeto',
            'refColumns'        => 'projeto_id'
        ),
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),

    );

}

