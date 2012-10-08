<?php

class Application_Model_DbTable_Projeto extends Zend_Db_Table_Abstract
{

   	protected $_name = 'projeto';

//'Application_Model_DbTable_EstadoProjeto' => array(

//Chave estrangeira na tabela projeto
//'columns'           => 'estado_projeto_id',

//nome classe relacionada
//'refTableClass'     => 'Application_Model_DbTable_EstadoProjeto',

//chave primaria da tabela relacionada
//'refColumns'        => 'estado_projeto_id'



    protected $_referenceMap    = array(
        'Application_Model_DbTable_CategoriaFinanciador' => array(
            'columns'           => 'categoria_financiador_id',
            'refTableClass'     => 'Application_Model_DbTable_CategoriaFinanciador',
            'refColumns'        => 'categoria_financiador_id'
        ),
        'Application_Model_DbTable_EstadoProjeto' => array(
            'columns'           => 'estado_projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_EstadoProjeto',
            'refColumns'        => 'estado_projeto_id'
        ),
        'Application_Model_DbTable_InstituicaoGerencia' => array(
            'columns'           => 'instituicao_gerencia_id',
            'refTableClass'     => 'Application_Model_DbTable_InstituicaoGerencia',
            'refColumns'        => 'instituicao_gerencia_id'
        ),
        'Application_Model_DbTable_ModoContratacao' => array(
            'columns'           => 'modo_contratacao_id',
            'refTableClass'     => 'Application_Model_DbTable_ModoContratacao',
            'refColumns'        => 'modo_contratacao_id'
        ),
        'Application_Model_DbTable_Prioridade' => array(
            'columns'           => 'prioridade_id',
            'refTableClass'     => 'Application_Model_DbTable_Prioridade',
            'refColumns'        => 'prioridade_id'
        ),
        'Application_Model_DbTable_ProjetoTipo' => array(
            'columns'           => 'projeto_tipo_id', //
            'refTableClass'     => 'Application_Model_DbTable_ProjetoTipo',
            'refColumns'        => 'projeto_tipo_id'
        ),
        'Coordenador' => array(
            'columns'           => 'coordenador_tecnico',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Gerente' => array(
            'columns'           => 'gerente',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Criador' => array(
            'columns'           => 'criador',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
    );
}

