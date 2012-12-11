<?php

class Application_Form_Cronogramafinanceiro extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('cronograma_financeiro');

        $id_projeto  = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'projeto_id', null );

        $this->setMethod('post');

        $nomeProjeto = Application_Model_Projeto::getNome($id_projeto);
        $this->addElement('text', 'nomeProjeto', array(
            'label'      => 'Projeto:',
            'value'      => $nomeProjeto['0']['nome'],
            'disabled'         => true,
            'required'   => false,
        ));

        $this->addElement('text', 'valor_aplicado_a_rubrica', array(
            'label'      => 'Valor Aplicado à Rubrica:',
            'required'   => true
        ));

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_previa');
        $emtDatePicker->setLabel('Data Prévia: ');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $array_tipo_pagamento = array(
            1 => 'Fatura',
            2 => 'PF',
        );

        $this->addElement('select', 'tipo', array(
            'label'      => 'Tipo:',
            'multiOptions'  => $array_tipo_pagamento,
            'required'   => true ,
            'attribs' => array('onChange' => 'tipoPagamento(this.value)'),
        ));

        $this->addElement('text', 'numero_fatura_pf', array(
            'label'      => 'Número da Fatura:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
            ''
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'label'      => '',
            'value'      => $id_projeto,
        ));


    }
}
