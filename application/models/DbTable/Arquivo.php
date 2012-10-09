<?php

class Application_Model_DbTable_Arquivo extends Zend_Db_Table_Abstract
{

 //'Application_Model_DbTable_EstadoProjeto' => array(

//Chave estrangeira na tabela projeto
//'columns'           => 'estado_projeto_id',

//nome classe relacionada
//'refTableClass'     => 'Application_Model_DbTable_EstadoProjeto',

//chave primaria da tabela relacionada
//'refColumns'        => 'estado_projeto_id'

    protected $_name = 'arquivo';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_TipoArquivo' => array(
            'columns'           => 'tipo_arquivo_id',
            'refTableClass'     => 'Application_Model_DbTable_TipoArquivo',
            'refColumns'        => 'tipo_arquivo_id'
        ),
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_PastaArquivo' => array(
            'columns'           => 'pasta_arquivo_id',
            'refTableClass'     => 'Application_Model_DbTable_PastaArquivo',
            'refColumns'        => 'pasta_arquivo_id'
        ),
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
        'Application_Model_DbTable_Instituicao' => array(
            'columns'           => 'instituicao_id',
            'refTableClass'     => 'Application_Model_DbTable_Instituicao',
            'refColumns'        => 'instituicao_id'
        ),
    );

}

