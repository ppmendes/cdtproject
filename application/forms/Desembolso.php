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

        //Empenho a liquidar input type text
        $this->addElement('select', 'empenho_id', array(
            'label'      => 'Empenho a liquidar:',
            'required'   => true,
            'multiOptions' => Application_Model_Desembolso::getOptions($this->id_projeto),
      //      'style'      => 'height: 70px',
        ));

        //Código do documento hábil input type text
        $this->addElement('text', 'codigo_documento_habil', array(
            'label'      => 'Código do Documento Hábil:',
            'required'   => true,
        ));

        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data_documento_habil');
        $emtDatePicker1->setLabel('Data Documento Hábil: ');
        $emtDatePicker1->setFilters(array('DateFilter'));
        $emtDatePicker1->setRequired(true);
        $this->addElement($emtDatePicker1);

        //Ordem Bancária input type text
        $this->addElement('text', 'order_dinheiro', array(
            'label'      => 'Ordem Bancária:',
            'required'   => true,
        ));

        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_pagamento');
        $emtDatePicker2->setLabel('Data de Pagamento: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
        $emtDatePicker2->setRequired(true);
        $this->addElement($emtDatePicker2);

        //Valor do Desembolso input type text
        $this->addElement('text', 'valor_desembolso', array(
            'label'      => 'Valor do Desembolso:',
            'required'   => true,
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')"
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Desembolso',
        ));


        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $this->id_projeto,
        ));

    }
}
