<?php

class Application_Form_Cronogramafinanceiro extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('cronograma_financeiro');

        $this->setMethod('post');

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('nomeProjeto');
        $emt->setLabel('Projeto:');
        $emt->setJQueryParam('data', Application_Model_Projeto::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#cronograma_financeiro-projeto_id").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        $this->addElement('text', 'valor_aplicado_a_rubrica', array(
            'label'      => 'Valor Aplicado à Rubrica:',
            'required'   => true
        ));

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_previa');
        $emtDatePicker->setLabel('Data Prévia: ');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $this->addElement('text', 'tipo', array(
            'label'      => 'Tipo:',
            'required'   => true
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
        ));


    }
}
