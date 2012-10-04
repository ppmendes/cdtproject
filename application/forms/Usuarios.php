<?php

class Application_Form_Usuarios extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        //$this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('usuario');

        // Setar metodo
        $this->setMethod('post');


        //tipo de usuario  input type radio
        $this->addElement('radio','tipo_usuario',array(
            'required' => true,
            'label' => 'Tipo:',
            'multiOptions'=>array('usuario'=>'usuario', 'contato'=>'contato')
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
        //data de nacimento input type text
        $this->addElement('text', 'data_nacimento', array(
            'label'      => 'Data de Nacimento:',
            'required'   => true
        ));

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

        //Perfil de usuario input type text
        $this->addElement('select', 'perfil_id', array(
            'label'      => 'Perfil do Usuario',
            'multiOptions' => Application_Model_PerfilUsuario::getOptions(),
            'required'   => true
        ));

        //instituicao input type text
        $this->addElement('select', 'instituicao_id', array(
            'label'      => 'Instituição:',
            'multiOptions' => Application_Model_Instituicao::getOptions(),
            'required'   => true
        ));

        //userName input type text
        $this->addElement('text', 'username', array(
            'label'      => 'Nome de Usuario:',
            'required'   => false
        ));

        //password input type text
        $this->addElement('text', 'password', array(
            'label'      => 'Password:',
            'required'   => true
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

        //notas input type text
        $this->addElement('text', 'notas', array(
            'label'      => 'Notas:',
            'required'   => false
        ));
        //icono ou imagen input type text
        $this->addElement('text', 'icono', array(
            'label'      => 'Notas:',
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

    }
}