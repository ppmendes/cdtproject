<?php

class Application_Model_DbTable_Tarefa extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefa'; // nome tabela no banco

     protected $_referenceMap    = array(
         'Application_Model_DbTable_TipoDuracao' => array(
             'columns'           => 'tipo_duracao_id',
             'refTableClass'     => 'Application_Model_DbTable_TipoDuracao',
             'refColumns'        => 'tipo_duracao_id'
         ),
         'Application_Model_DbTable_EstadoTarefa' => array(
             'columns'           => 'estado_tarefa_id',
             'refTableClass'     => 'Application_Model_DbTable_EstadoTarefa',
             'refColumns'        => 'estado_tarefa_id'
         ),
         'Application_Model_DbTable_Prioridade' => array(
             'columns'           => 'prioridade_id',
             'refTableClass'     => 'Application_Model_DbTable_Prioridade',
             'refColumns'        => 'prioridade_id'
         ),
         'Application_Model_DbTable_Usuario' => array(
             'columns'           => 'criador',
             'refTableClass'     => 'Application_Model_DbTable_Usuario',
             'refColumns'        => 'usuario_id'
         ),
         'Application_Model_DbTable_TipoTarefa' => array(
             'columns'           => 'tipo_tarefa_id',
             'refTableClass'     => 'Application_Model_DbTable_TipoTarefa',
             'refColumns'        => 'tipo_tarefa_id'
         ),
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

