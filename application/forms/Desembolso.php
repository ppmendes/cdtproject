<?php

class Application_Form_Desembolso extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('desembolso');

        // Setar metodo
        $this->setMethod('post');

        //Filtro por processo input type text
        $this->addElement('text', 'desembolso_rel', array(
            'label'      => 'Filtro por processo:',
            'required'   => true,
        ));

        //Empenho a liquidar input type text
        $this->addElement('select', 'empenho_id', array(
            'label'      => 'Empenho a liquidar:',
            'multiOptions' => Application_Model_Empenho::getOptions(),
            'required'   => true,
        ));

        //Código do documento hábil input type text
        $this->addElement('text', 'codigo_documento_habil', array(
            'label'      => 'Código do Documento Hábil:',
            'required'   => true,
        ));

        //Data Documento Hábil input type text
        $this->addElement('text', 'data_documento_habil', array(
            'label'      => 'Data Documento Hábil:',
            'required'   => true,
        ));

        //Ordem Bancária input type text
        $this->addElement('text', 'order_dinheiro', array(
            'label'      => 'Ordem Bancária:',
            'required'   => true,
        ));

        //Data do Pagamento input type text
        $this->addElement('text', 'data_pagamento', array(
            'label'      => 'Data do Pagamento:',
            'required'   => true,
        ));

        //Valor do Desembolso input type text
        $this->addElement('text', 'valor_desembolso', array(
            'label'      => 'Valor do Desembolso:',
            'required'   => true,
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Desembolso',
        ));

    }
}
