<?php

class Application_Form_Desembolso extends Zend_Form
{

    private $id_projeto;

    public function setProjetoId($id_projeto){
        $this->id_projeto = $id_projeto;
    }

    public function init() {}

    public function startform()
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
        $this->addElement('text', 'empenho', array(
            'label'      => 'Empenho a liquidar:',
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

        $this->addElement('hidden', 'empenho_id', array(
            'value'      => '',
        ));

        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $this->id_projeto,
        ));

    }
}
