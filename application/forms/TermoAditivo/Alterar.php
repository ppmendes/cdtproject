<?php

class Application_Form_TermoAditivo_Alterar extends Zend_Form
{

    public function init(){

    }

    public function startform()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('termo_aditivo');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Alteração de uma Rubrica',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $id_projeto  = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'projeto_id', null );

//        $emt = new ZendX_JQuery_Form_Element_AutoComplete('termoAditivoAlterar');
//        $emt->setLabel('Elemento de Despesa Destinatário:');
//       $emt->setJQueryParam('data', Application_Model_Orcamento::getCodigoDescricaoRubricaValorOrcamentoNomeDestino($id_projeto))
//            ->setJQueryParams(array("select" => new Zend_Json_Expr(
//            'function(event,ui) { $("#termo_aditivo-orcamento_destino").val(ui.item.id) }')
//        ));
//        $this->addElement($emt);

        $this->addElement('text', 'termoAditivoAlterar', array(
            'label'      => '*Elemento de Despesa Destinatário: ',
            'ignore'     => true,
            'required'   => true,
        ));

        //Coordenador do projeto input type text
        $this->addElement('text', 'valor_termino_aditivo', array(
            'label'      => 'Valor (R$):',
            'required'   => true,
            'attribs'    => array('maxLength' => 13),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
        ));
        // echo "<script> mascara(); </script>";

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
        $this->addElement('hidden', 'orcamento_destino', array(
            'value'      => ''
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $id_projeto
        ));


        $usuario_logado = Zend_Auth::getInstance()->getStorage()->read();

        //set hidden
        $this->addElement('hidden', 'usuario_id', array(
            'value'      => $usuario_logado->usuario_id,
        ));

        //set hidden
        $this->addElement('hidden', 'tipo_termo_aditivo_id', array(
            'value'      => '3'
        ));

        //set hidden
        $this->addElement('hidden', 'saldo_orcamento', array(
            'value'      => ''
        ));

    }
}



