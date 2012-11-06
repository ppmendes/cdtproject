<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Laura
 * Date: 19/09/12
 * Time: 15:30
 * To change this template use File | Settings | File Templates.
 */
class Application_Form_Arquivos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('arquivos');

        // Setar metodo
        $this->setMethod('post');

        // array para atributo pasta

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
            'function(event,ui) { $("#arquivos-autoid").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        //tarefa id pai  da tarefa select type
        $this->addElement('text', 'tarefa_id', array(
            'label'      => 'tarefa:',
            'multiOptions'  =>Application_Model_Tarefa::getOptions(),
            'required'   => true
        ));

        //projeto id pai  da tarefa select type
        $this->addElement('select', 'instituicao_id', array(
            'label'      => 'Instituicao:',
            'multiOptions'  =>Application_Model_Instituicao::getOptions(),
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Arquivo',
        ));

        //set hidden
        $this->addElement('hidden', 'autoid', array(
            'label'      => '',
            'value'      => ''
        ));
    }
}
