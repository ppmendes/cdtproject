<?php

class Application_Form_Beneficiarios extends Zend_Form
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
        $this->addElement('text', 'banco_id', array(
            'label'      => 'Banco:',
            'required'   => true,
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
        $this->addElement('text', 'educacao', array(
            'label'      => 'Escolaridade:',
            'required'   => true,
        ));

        //E-mail input type text
        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
        ));

        //Área do conhecimento input type text
        $this->addElement('text', 'area_conhecimento', array(
            'label'      => 'Área do conhecimento:',
            'required'   => true,
        ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Beneficiário',
        ));

    }
}
