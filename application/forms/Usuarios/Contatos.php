<?php

class Application_Form_Usuarios_Contatos extends Zend_Form
{
    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('usuario');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Usuários Contatos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        //nome do usuario input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome:',
            'required'   => true,
        ));

        //sobrenome input type text
        $this->addElement('text', 'sobrenome', array(
            'label'      => 'Sobrenome:',
            'required'   => true
        ));
        //data de nascimento input type text
        /*$this->addElement('text', 'data_nascimento', array(
            'label'      => 'Data de Nascimento:',
            'required'   => true,
            'class'      => 'datePicker'
        ));*/
        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_nascimento');
        $emtDatePicker->setLabel('Data de Nascimento: ');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        //website type text
        $this->addElement('text', 'website_lattes', array(
            'label'      => 'Currículo Lattes (url):',
            'required'   => true
        ));

        //ocupacao input type text
        $this->addElement('text', 'ocupacao', array(
            'label'      => 'Ocupação:',
            'required'   => true
        ));

        //Cargo no trabalho input type text
        $this->addElement('text', 'cargo_trabalho', array(
            'label'      => 'Cargo do Trabalho:',
            'required'   => true
        ));



        // projeto autocomplete
        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Instituição:');
        $emt->setJQueryParam('data', Application_Model_Instituicao::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#usuario-instituicao_id").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        //instituicao input type text
        /*$this->addElement('select', 'instituicao_id', array(
            'label'      => 'Instituição:',
            'multiOptions' => Application_Model_Instituicao::getOptions(),
            'required'   => true
        ));*/

        //tipo de usuario  input type radio
        $this->addElement('checkbox','tipo_usuario',array(
            'required' => false,
            'label' => 'Usuário do sistema:',
            'uncheckedValue' => 'contato',
            'checkedValue' => 'usuario',
            'attribs' => array('onChange' => 'tipoUsuario(this.value)'),
        ));

        //email input type text
        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => false
        ));
        //telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => false
        ));
        //celular input type text
        $this->addElement('text', 'celular', array(
            'label'      => 'Celular:',
            'required'   => false
        ));
        //Endereço input type text
        $this->addElement('text', 'endereco', array(
            'label'      => 'Endereço:',
            'required'   => true
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
            // 'id'         => 'estado',
            'label'      => 'Estado:',
            'multiOptions' => Application_Model_Estados::getOptions(),
            'required'   => false,
            'attribs'    => array('onchange' => 'carregaCidades(this.value)')
        ));

        //Cidade input type text
        $this->addElement('select', 'cidade_id', array(
            //  'id'         => 'cidade',
            'label'      => 'Cidade:',
            'multiOptions' => Application_Model_Cidade::getOptions(),
            'required'   => false,
        ));

        $this->addElement('text', 'cidade_text', array(
            'label'      => 'Cidade/Estado:',
            'required'   => false
        ));

        //CEP input type textarea
        $this->addElement('text', 'cep', array(
            'label'      => 'CEP:',
            'required'   => true
        ));

        //notas input type text
        $this->addElement('text', 'notas', array(
            'label'      => 'Notas:',
            'required'   => false
        ));

        //icono ou imagen input type text
        $this->addElement('file', 'icone', array(
            'label'      => 'Icone:',
            'required'   => false
        ));

        //Descrição input type text
        $this->addElement('text', 'assinatura', array(
            'label'      => 'Assinatura:',
            'required'   => false
        ));

        //pai_id input type text
        $this->addElement('text', 'email_assinatura', array(
            'label'      => 'Assinatura do E-mail:',
            'required'   => false
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Usuario',
        ));

        //set hidden
        $this->addElement('hidden', 'instituicao_id', array(
            'value'      => ''
        ));
    }
}