<?php

class Application_Form_TermoAditivo_Remanejar extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('termo_aditivo');

        // Setar metodo
        $this->setMethod('post');

        $emf = new ZendX_JQuery_Form_Element_AutoComplete('termoAditivoRemanejar1');
        $emf->setLabel('Elemento de Despesa Fonte:');
        $emf->setJQueryParam('data', Application_Model_Orcamento::getCodigoDescricaoRubricaValorOrcamentoNomeDestino())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#termo_aditivo-orcamento_id_fonte").val(ui.item.id) }')
        ));
        $this->addElement($emf);

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('termoAditivoRemanejar2');
        $emt->setLabel('Elemento de Despesa Destinatário:');
        $emt->setJQueryParam('data', Application_Model_Orcamento::getCodigoDescricaoRubricaValorOrcamentoNomeDestino())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#termo_aditivo-orcamento_id_destino").val(ui.item.id) }')
        ));
        $this->addElement($emt);
        //Coordenador do projeto input type text
        $this->addElement('text', 'valor', array(
            'label'      => 'Valor (R$):',
            'required'   => true
        ));

        //Gerência input type text
        $this->addElement('textarea', 'descricao_justificativa', array(
            'label'      => 'Motivo/Descrição:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

        //set hidden
        $this->addElement('hidden', 'orcamento_id_fonte', array(
            'value'      => ''
        ));

        //set hidden
        $this->addElement('hidden', 'orcamento_id_destino', array(
            'value'      => ''
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => '1'
        ));

        //set hidden
        $this->addElement('hidden', 'usuario_id', array(
            'value'      => '1'
        ));

        //set hidden
        $this->addElement('hidden', 'tipo_termo_aditivo_id', array(
            'value'      => '2'
        ));
    }
}
