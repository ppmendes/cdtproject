<?php

class Application_Form_Beneficiarios_Beneficiariospf extends Zend_Form
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
            'attribs'    => array('onchange' => 'tipoBeneficiario(this.value)'),
            'required'   => true,
        ));

        //Nome input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome:',
            'required'   => true,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CPF:',
            'required'   => true,
//            'attribs'    => array('maxLength' => 12),
//            'onkeyup' => "this.value=mask(this.value, '##########-##')",

        ));

        //Telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
        ));

        //RG input type text
        $this->addElement('text', 'rg_ie', array(
            'label'      => 'RG:',
            'required'   => false,
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
            'required'   => false,
        ));

        //Escolaridade input type text

        $this->addElement('select', 'escolaridade_id', array(
            'label'      => 'Escolaridade:',
            'multiOptions' => Application_Model_Escolaridade::getOptions(),
            'required'   => false
        ));

        //E-mail input type text
        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
        ));

        //Área do conhecimento input type text

        $this->addElement('select', 'area_conhecimento_id', array(
            'label'      => 'Área do conhecimento:',
            'multiOptions' => Application_Model_AreaConhecimento::getOptions(),
            'required'   => false
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
            //  'attribs'    => array( 'setRegisterInArrayValidator' => false),
            'attribs'    => array('onchange' => 'carregaCidades(this.value)')
        ));

        //Cidade input type text
        $this->addElement('select', 'cidade_id', array(
            //'id'         => 'cidade',
            'label'      => 'Cidade:',
            'multiOptions' => Application_Model_Cidade::getOptions(),
            'required'   => false,
            // 'attribs'    => array( 'setRegisterInArrayValidator' => false),
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
