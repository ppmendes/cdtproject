<?php

class Application_Form_Arquivos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('arquivos');

        // Setar metodo xxx
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Arquivos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        //nome real do arquivo input type text
        $this->addElement('text', 'nome_real', array(
            'label'      => 'Nome Real:',
            'required'   => true,
        ));

        $this->addElement('file', 'nome_arquivo', array(
            'label'      => 'Enviar Arquivo:',
            'required'   => false
        ));

        //descriçao do arquivo input type textarea
        $this->addElement('textarea', 'descricao_arquivo', array(
            'label'      => 'Descrição:',
            'required'   => true
        ));


        //tipo de arquivo select type
        $this->addElement('select', 'tipo_arquivo_id', array(
            'label'      => 'Tipo de Arquivo:',
            'multiOptions'  => Application_Model_TipoArquivo::getOptions(),
            'required'   => true
        ));

        //dono do arquivo input type text
        //item preenchido automaticamnete
        $this->addElement('text', 'dono_arquivo', array(
            'label'      => 'Dono:',
            'required'   => true,
        ));

        // projeto autocomplete
        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Projeto:');
        $emt->setJQueryParam('data', Application_Model_Projeto::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#arquivos-projeto_id").val(ui.item.id) }')))
            ->setAttribs(array('onchange'=>'atualizarTarefas($("#arquivos-autoid").val())'));

        $this->addElement($emt);

        //tarefa id pai  da tarefa select type
        $this->addElement('select', 'tarefa_id', array(
            'label'      => 'tarefa:',
            //'multiOptions'  =>Application_Model_Tarefa::getOptions1(),
            'required'   => false,
            'value'=>'0',
        ));

        /*$emt = new ZendX_JQuery_Form_Element_AutoComplete('aci');
        $emt->setLabel('Instituição:');
        $emt->setJQueryParam('data', Application_Model_Instituicao::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#arquivos-instituicao_id").val(ui.item.id) }')
        ));
        $this->addElement($emt);*/

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Arquivo',
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'label'      => '',
            'value'      => ''
        ));

        //set hidden
        /*$this->addElement('hidden', 'instituicao_id', array(
            'value'      => ''
        ));*/
    }
}
