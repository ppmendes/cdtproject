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

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Remanejamento do Valor de Rubricas',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $id_projeto  = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'projeto_id', null );

        $emf = new ZendX_JQuery_Form_Element_AutoComplete('termoAditivoRemanejar1');
        $emf->setLabel('Elemento de Despesa Fonte:');
        $emf->setJQueryParam('data', Application_Model_Orcamento::getCodigoDescricaoRubricaValorOrcamentoNomeDestino($id_projeto))
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#termo_aditivo-orcamento_origem").val(ui.item.id) }')
        ));
        $this->addElement($emf);

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('termoAditivoRemanejar2');
        $emt->setLabel('Elemento de Despesa Destinatário:');
        $emt->setJQueryParam('data', Application_Model_Orcamento::getCodigoDescricaoRubricaValorOrcamentoNomeDestino($id_projeto))
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#termo_aditivo-orcamento_destino").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        //Coordenador do projeto input type text
        $this->addElement('text', 'valor_termino_aditivo', array(
            'label'      => 'Valor (R$):',
            'required'   => true,
            'attribs'    => array('maxLength' => 13),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
        ));

        //Gerência input type text
        $this->addElement('textarea', 'termo_aditivo_descricao', array(
            'label'      => 'Motivo/Descrição:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

        //set hidden
        $this->addElement('hidden', 'orcamento_origem', array(
            'value'      => ''
        ));

        //set hidden
        $this->addElement('hidden', 'orcamento_destino', array(
            'value'      => ''
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $id_projeto
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
