<?php

class Application_Form_Beneficiarios_Beneficiariospf extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('beneficiario');

        // Setar metodo
        $this->setMethod('post');

        //Nome input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome:',
            'required'   => true,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CPF:',
            'required'   => true,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
        ));

        //RG input type text
        $this->addElement('text', 'rg_ie', array(
            'label'      => 'RG:',
            'required'   => true,
        ));

        //Endereço input type text
        $this->addElement('text', 'endereco', array(
            'label'      => 'Endereço:',
            'required'   => true,
        ));

        //Banco input type text

        $this->addElement('select', 'banco_id', array(
            'label'      => 'Banco:',
            'multiOptions' => Application_Model_Banco::getOptions(),
            'required'   => true
        ));
        //Agencia input type text
        $this->addElement('text', 'agencia_banco', array(
            'label'      => 'Agência:',
            'required'   => true,
        ));

        //Conta input type text
        $this->addElement('text', 'conta_bancaria', array(
            'label'      => 'Conta:',
            'required'   => true,
        ));

        //NIT/PIS input type text
        $this->addElement('text', 'nit_pis', array(
            'label'      => 'NIT/PIS:',
            'required'   => true,
        ));

        //Escolaridade input type text

        $this->addElement('select', 'escolaridade_id', array(
            'label'      => 'Escolaridade:',
            'multiOptions' => Application_Model_Escolaridade::getOptions(),
            'required'   => true
        ));

        //E-mail input type text
        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
        ));

        //Área do conhecimento input type text

        $this->addElement('select', 'area_conhecimento_id', array(
            'label'      => 'Área do conhecimento::',
            'multiOptions' => Application_Model_AreaConhecimento::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'tipo_beneficiario_id', array(
            'label'      => 'Tipo do Beneficiário:',
            'multiOptions' => Application_Model_TipoBeneficiario::getOptions(),
            'required'   => true,
        ));

        $this->addElement('select', 'pais_id', array(
            'label'      => 'País:',
            'multiOptions' => Application_Model_Pais::getOptions(),
            'required'   => true,
        ));

        $this->addElement('select', 'estados_id', array(
            'label'      => 'Estado:',
            'multiOptions' => Application_Model_Estados::getOptions(),
            'required'   => true,
        ));

        $this->addElement('select', 'cidade_id', array(
            'label'      => 'Cidade:',
            'multiOptions' => Application_Model_Cidade::getOptions(),
            'required'   => true,
        ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

    }
}
