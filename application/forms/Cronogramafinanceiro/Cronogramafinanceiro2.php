<?php

class Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2 extends Zend_Form
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

        $orcamento = Application_Model_Projeto::getValorOrcamento($this->id_projeto);
        $valorLimite = $orcamento['0']['orcamento'] - $this->valorParcelas;
        $this->addElement('text', 'saldo', array(
            'label'     => 'Saldo Atual:',
            'value'     => $orcamento['0']['orcamento'],
            'disabled'  => true,
            'required'  => false,
        ));

        $this->addElement('text', 'valor_aplicado_a_rubrica', array(
            'label'      => 'Valor estimado da parcela:',
            'required'   => true,
            'attribs'    => array('maxLength' => 13),
        ));

        $elemento = $this->getElement('valor_aplicado_a_rubrica');
        $elemento->addValidator(new Zend_Validate_Between(array('min' => 0, 'max' => $valorLimite)));

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
            'value'      => $valorLimite,
        ));


    }
}
