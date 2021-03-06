<?php

class Application_Form_Cronogramaorcamentario_Cronogramaorcamentario2 extends Zend_Form
{
    private $valorParcelas;
    private $id_projeto;

    public function setValorParcelas($valor){
        $this->valorParcelas = $valor;
    }

    public function setProjetoId($id_projeto){
        $this->id_projeto = $id_projeto;
    }

    public function init() {}

    public function startform()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('cronograma_orcamentario');

        //$id_projeto  = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'projeto_id', null );

        $this->setMethod('post');


        $nomeProjeto = Application_Model_Projeto::getNome($this->id_projeto);
        $this->addElement('text', 'nomeProjeto', array(
            'label'      => 'Projeto:',
            'value'      => $nomeProjeto['0']['nome'],
            'readonly'   => true,
            'ignore'     => true,
        ));

        // $orcamento = Application_Model_Projeto::getValorOrcamento($this->id_projeto);
        //$valorLimite = number_format($orcamento['0']['orcamento'] - $this->valorParcelas, 2);

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_previa');
        $emtDatePicker->setLabel('Data Prevista: ');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $this->addElement('text', 'valor_a_receber', array(
            'label'     => 'Orçamento previsto:',
            //  'value'     => $valorLimite,
            'required'  => true,
            'attribs'    => array('maxLength' => 13),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
        ));

        //$valorSaldo = Application_Model_CronogramaFinanceiro::calculaTotal()
        $this->addElement('text', 'valor_recebido', array(
            'label'      => 'Orçamento disponibilizado:',
            'required'   => false,
            'value'      => '0,00',
            'attribs'    => array('maxLength' => 13),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
        ));

        //  $elemento = $this->getElement('valor_aplicado_a_rubrica');
        //  $elemento->addValidator(new Zend_Validate_Between2(array('min' => 0, 'max' => $valorLimite)));
        //$elemento->setFilters(array('DecimalFilter'));

        $array_tipo_pagamento = array(
            1 => 'Fatura',
            2 => 'PF',
        );

        $this->addElement('select', 'tipo', array(
            'label'      => 'Tipo:',
            'multiOptions'  => $array_tipo_pagamento,
            'required'   => true ,
            'value'   => 2,
            'attribs' => array('onChange' => 'tipoPagamento(this.value)'),
        ));

        echo "<script>chamaTipoPagamento(2)</script>";

        $this->addElement('text', 'numero_fatura_pf', array(
            'label'      => 'Número PF:',
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
            'value'      => $this->id_projeto,
        ));


    }
}
