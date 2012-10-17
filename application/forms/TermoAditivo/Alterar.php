<?php

class Application_Form_TermoAditivo_Alterar extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('termoaditivo');

        // Setar metodo
        $this->setMethod('post');

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('termoAditivoAlterar');
        $emt->setLabel('Elemento de Despesa Destinatário:');
        $emt->setJQueryParam('data', Application_Model_Orcamento::getCodigoDescricaoRubricaValorOrcamentoNomeDestino())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#termoaditivo-orcamento_id").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        //Coordenador do projeto input type text
        $this->addElement('text', 'valor', array(
            'label'      => 'Valor (R$):',
            'required'   => true
        ));

        //Gerência input type text
        $this->addElement('textarea', 'descricao', array(
            'label'      => 'Motivo/Descrição:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

        //set hidden
        $this->addElement('hidden', 'orcamento_id', array(
            'value'      => ''
        ));

    }
}
