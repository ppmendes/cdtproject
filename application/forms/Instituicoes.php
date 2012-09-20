<?php

class Application_Form_Instituicoes extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('instituicao');

        // Setar metodo
        $this->setMethod('post');

        //Nome da instituição input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome da instituição:',
            'required'   => true,
        ));

        //Sigla da instituiçãp input type text
        $this->addElement('text', 'siglas', array(
            'label'      => 'Sigla da instituição:',
            'required'   => true,
        ));

        //CNPJ input type text
        $this->addElement('text', 'cnpj', array(
            'label'      => 'CNPJ:',
            'required'   => true
        ));

        //E-mail input type text
        $this->addElement('text', 'e_mail', array(
            'label'      => 'E-mail:',
            'required'   => true
        ));

        //Telefone type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true
        ));

        //Celular input type text
        $this->addElement('text', 'telefone2', array(
            'label'      => 'Celular:',
            'required'   => true
        ));

        //Fax input type text
        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
            'required'   => false
        ));

        //Endereço input type text
        $this->addElement('text', 'endereco', array(
            'label'      => 'Endereço:',
            'required'   => true
        ));

        //Complemento input type text
        $this->addElement('text', 'complemento', array(
            'label'      => 'Complemento:',
            'required'   => false
        ));

        //Cidade input type text
        $this->addElement('text', 'cidade', array(
            'label'      => 'Cidade:',
            'required'   => true
        ));

        //Estado input type text
        $this->addElement('text', 'estado', array(
            'label'      => 'Estado:',
            'required'   => true
        ));

        //CEP input type textarea
        $this->addElement('text', 'cep', array(
            'label'      => 'CEP:',
            'required'   => true
        ));

        //Website input type text
        $this->addElement('text', 'website', array(
            'label'      => 'Website:',
            'required'   => false
        ));

        //Responsável pela instituição input type text
        $this->addElement('text', 'responsavel', array(
            'label'      => 'Responsável pela instituição:',
            'required'   => true
        ));

        //Tipo de instituição input type text
        $this->addElement('text', 'tipo', array(
            'label'      => 'Tipo de instituição:',
            'required'   => true
        ));

        //Descrição input type text
        $this->addElement('text', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => false
        ));

        //Denominação input type text
        $this->addElement('text', 'denominacao', array(
            'label'      => 'Denominação:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Instituição',
        ));

    }
}
