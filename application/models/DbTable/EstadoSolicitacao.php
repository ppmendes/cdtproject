<?php

class Application_Model_DbTable_EstadoSolicitacao extends Zend_Db_Table_Abstract
{

    protected $_name = 'estado_solicitacao';

     protected $_referenceMap    = array(
         'Application_Model_DbTable_Institucao' => array(
             'columns'           => 'instituicao_id',
             'refTableClass'     => 'Application_Model_DbTable_Institucao',
             'refColumns'        => 'institucao_id'
         ),
     );
}

