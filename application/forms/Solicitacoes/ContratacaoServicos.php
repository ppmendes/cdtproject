<?php

class Application_Form__Solicitacoes_ContratacaoServicos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('solicitacoes');

        // Setar metodo
        $this->setMethod('post');

        //Nome da solicitação input type text
        $this->addElement('text', 'solicitacao_nome', array(
            'label'      => 'Nome da Solicitação:',
            'required'   => true,
        ));

        //Data da solicitação
        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data_solicitacao');
        $emtDatePicker1->setLabel('Data da solicitação: ');
        $emtDatePicker1->setJQueryParam('dateFormat', 'yy-mm-dd');
        $this->addElement($emtDatePicker1);

        //Projeto input type text
        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto:',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true
        ));

        //Coordenador do projeto input type text
        $this->addElement('select', 'coodenador_projeto', array(
            'label'      => 'Coordenador do Projeto:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true
        ));

        //Tipo de solicitação input type text
        $this->addElement('select', 'tipo_solicitacao_id', array(
            'label'      => 'Tipo de solicitação:',
            'multiOptions' => Application_Model_TipoSolicitacao::getOptions(),
            'required'   => true
        ));

        //Beneficiário input type text
        $this->addElement('select', 'beneficiario_id', array(
            'label'      => 'Beneficiário:',
            'multiOptions' => Application_Model_Beneficiario::getOptions(),
            'required'   => true
        ));

        //Número de itens input type text
        $this->addElement('text', 'numero_items', array(
            'label'      => 'Número de itens:',
            'required'   => true
        ));

        $this->addElement('text', 'valor_estimado', array(
            'label'      => 'Valor estimado:',
            'required'   => true
        ));

        $this->addElement('text', 'local_entrega_solicitacao', array(
            'label'      => 'Local de entrega:',
            'required'   => true
        ));

        $this->addElement('text', 'resultados_esperados', array(
            'label'      => 'Resultados esperados:',
            'required'   => true
        ));

        $this->addElement('text', 'objetivo_solicitacao', array(
            'label'      => 'Objetivo:',
            'required'   => true
        ));

        $this->addElement('text', 'justificativa', array(
            'label'      => 'Justificativa:',
            'required'   => true
        ));

        $this->addElement('text', 'observacao', array(
            'label'      => 'Observação:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));


    }
}
