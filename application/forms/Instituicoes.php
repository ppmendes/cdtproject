<?php

class Application_Form_Instituicoes extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        //$this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('instituicao');

        // Setar metodo comentario
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Instituições',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

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
            //'multiOptions' => Application_Model_Estados::getOptions(),
            'required'   => false,
            //'attribs'    => array( 'setRegisterInArrayValidator' => false),
            'attribs'    => array('onchange' => 'carregaCidades(this.value)')
        ));

        //Cidade input type text
        $this->addElement('select', 'cidade_id', array(
           // 'id'         => 'cidade',
            'label'      => 'Cidade:',
            //'multiOptions' => Application_Model_Cidade::getOptions(),
            'required'   => false,
            //'attribs'    => array( 'setRegisterInArrayValidator' => false),
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

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Instituição Pai:');
        $emt->setJQueryParam('data', Application_Model_Instituicao::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#instituicao-instituicao_id").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        $this->addElement('button', 'botaoPesquisa', array(
            'required' => false,
            'label'     => 'Pesquisar',
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

        //set hidden
        $this->addElement('hidden', 'instituicao_id', array(
            'value'      => ''
        ));

    }
}
