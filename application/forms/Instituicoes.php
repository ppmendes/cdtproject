<?php

class Application_Form_Instituicoes extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        //$this->setAttrib('enctype', 'multipart/form-data');
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
        //Responsável pela instituição input type text
        $this->addElement('text', 'responsavel', array(
            'label'      => 'Responsável pela instituição:',
            'required'   => true
        ));

        //Telefone type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true
        ));

        //E-mail input type text
        $this->addElement('text', 'e_mail', array(
            'label'      => 'E-mail:',
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

        //pais input type text
        $this->addElement('select', 'pais_id', array(
            'label'      => 'Pais:',
            'multiOptions' => Application_Model_Pais::getOptions(),
            'required'   => true
        ));

        //Estado input type text
        $this->addElement('select', 'estados_id', array(
            'label'      => 'Estado:',
            'multiOptions' => Application_Model_Estados::getOptions(),
            'required'   => true
        ));

        //Cidade input type text
        $this->addElement('select', 'cidade_id', array(
            'label'      => 'Cidade:',
            'multiOptions' => Application_Model_Cidade::getOptions(),
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

        //pai_id input type text
        $this->addElement('text', 'pai_id', array(
            'label'      => 'Instituicao Pai:',
            'required'   => false
        ));

        //Denominação input type text
        $this->addElement('select', 'denominacao_id', array(
            'label'      => 'Denominação:',
            'multiOptions' => Application_Model_Denominacao::getOptions(),
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Instituição',
        ));

    }
}
