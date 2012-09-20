<?php

class Application_Model_DbTable_ProjetoBeneficiario extends Zend_Db_Table_Abstract
{

    protected $_name = 'projeto_beneficiario'; // nome tabela no banco

       protected $_referenceMap    = array(
           'Application_Model_DbTable_Projeto' => array(
               'columns'           => 'projeto_id',
               'refTableClass'     => 'Application_Model_DbTable_Projeto',
               'refColumns'        => 'projeto_id'
           ),
           'Application_Model_DbTable_Beneficiario' => array(
               'columns'           => 'beneficiario_id',
               'refTableClass'     => 'Application_Model_DbTable_Beneficiario',
               'refColumns'        => 'beneficiario_id'
           ),
    );

}

