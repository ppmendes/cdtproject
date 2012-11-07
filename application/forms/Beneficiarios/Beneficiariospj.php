<?php

class Application_Form_Beneficiarios_Beneficiariospj extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('beneficiario');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Beneficiários',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $this->addElement('select', 'tipo_beneficiario_id', array(
            'label'      => 'Tipo do Beneficiário:',
            'multiOptions' => Application_Model_TipoBeneficiario::getOptions(),
            'required'   => true,
        ));

        //Nome input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome:',
            'required'   => true,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CNPJ:',
            'required'   => true,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
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

        //E-mail input type text
        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
        ));

        //pais input type text
        $this->addElement('select', 'pais_id', array(
            //'id'         => 'pais',
            'label'      => 'Pais:',
            'multiOptions' => Application_Model_Pais::getOptions(),
            'required'   => true,
            'attribs'    => array('onchange' => 'carregaEstados(this.value)'),
            'value'     => '76',
        ));

        //Estado input type text
        $this->addElement('select', 'estados_id', array(
            //'id'         => 'estado',
            'label'      => 'Estado:',
            'multiOptions' => Application_Model_Estados::getOptions(),
            'required'   => false,
            'attribs'    => array('onchange' => 'carregaCidades(this.value)')
        ));

        //Cidade input type text
        $this->addElement('select', 'cidade_id', array(
            // 'id'         => 'cidade',
            'label'      => 'Cidade:',
            'multiOptions' => Application_Model_Cidade::getOptions(),
            'required'   => false,
        ));

        $this->addElement('text', 'cidade_text', array(
            'label'      => 'Cidade/Estado:',
            'required'   => false
        ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

    }
}
