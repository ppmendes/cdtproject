<?php

class Application_Form_Desembolso extends Zend_Form
{

    private $id_projeto;
    private $saldo_financeiro;

    public function setProjetoId($id_projeto){
        $this->id_projeto = $id_projeto;
    }

    public function setSaldoFinanceiro($saldo_financeiro){
        $this->saldo_financeiro = $saldo_financeiro;
    }

    public function init() {}

    public function startform()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('desembolso');

        // Setar metodo
        $this->setMethod('post');

        //Empenho a liquidar input type text
        $array_empenhos_a_liquidar = Application_Model_Desembolso::getOptions($this->id_projeto);

        $this->addElement('select', 'empenho_id', array(
            'label'      => 'Empenho a liquidar:',
            'required'   => true,
            'multiOptions' => $array_empenhos_a_liquidar,
            'attribs'    => array('onchange' => 'saldoEmpenho(this.value)'),
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
            'class' => 'mask_ordem',
            //'onkeyup' => "this.value=mask(this.value, '####OB######')"
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
            'attribs'    => array('maxLength' => 13),
            //'class' => 'mask_valor',
            'validators' => array(array('Digits')),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",


        ));

        $elemento = $this->getElement('valor_desembolso');
        $elemento->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => $this->saldo_financeiro)));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Desembolso',
        ));


        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $this->id_projeto,
        ));

        $this->addElement('hidden', 'saldo_financeiro', array(
            'value'      => $this->saldo_financeiro,
            'ignore'     => true,
        ));

        $this->addElement('hidden', 'saldo_empenho', array(
            'value'      => '',
            'ignore'     => true,
        ));

    }


    public function preValidation(array $data)
    {
        $dados = $_POST;
        $valor_desembolso = $this->getElement('valor_desembolso');
        $saldo_empenho = $dados['desembolso']['saldo_empenho'];
        $saldo_financeiro = $dados['desembolso']['saldo_financeiro'];

        $valor_desembolso->removeValidator('Zend_Validate_Between2');
        if ($saldo_empenho > $saldo_financeiro)
        {
            $valor_desembolso->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => $saldo_financeiro)));
        }else
        {
            $valor_desembolso->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => $saldo_empenho)));
        }

    }
}
