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

        $this->addElement('hidden', 'label_projeto', array(
            'description' => 'Identificação do Projeto',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

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

        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true
        ));

        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true
        ));

        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
            'required'   => false
        ));

        $this->addElement('hidden', 'label_beneficiario', array(
            'description' => 'Dados do Contratado',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
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
