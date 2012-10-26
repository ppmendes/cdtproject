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

        //nome do arquivo input type text

        /*$file = new Zend_Form_Element_File('file');
        $path="public/files/arquivos/";
        $file->setDestination($path)
            ->setLabel('Arquivo:')
            ->setRequired(true)
            ->addValidator('NotEmpty');*/

        //$this->addElement($file);

        $this->addElement('file', 'nome_arquivo', array(
            'label'      => 'Arquivo:',
            'required'   => false
        ));

        //arquivo id pai  da tarefa select type
        /*$this->addElement('text', 'arquivo_id_pae', array(
            'label'      => 'Arquivo Pae:',
            //'multiOptions'  => $array_pasta_arquivo,
            'required'   => false
        ));*/

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


        //versao do arquivo input type text
        /*$this->addElement('text', 'versao', array(
            'label'      => 'Versão:',
            'required'   => true,
        ));*/

        //icono do arquivo input type text
        /*$this->addElement('text', 'icon_arquivo', array(
            'label'      => 'Ícone:',
            'required'   => true,
        ));*/

        //pasta do arquivo select type
        /*$this->addElement('select', 'pasta_arquivo_id', array(
            'label'      => 'Pasta:',
            'multiOptions'  => Application_Model_PastaArquivo::getOptions(),
            'required'   => true
        ));*/

        //projeto id pai  da tarefa select type
        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto:',
            'multiOptions'  =>Application_Model_Projeto::getOptions(),
            'required'   => true
        ));

        //tarefa id pai  da tarefa select type
        $this->addElement('text', 'tarefa_id', array(
            'label'      => 'tarefa:',
            'multiOptions'  =>Application_Model_Projeto::getOptions(),
            'required'   => true
        ));
        //projeto id pai  da tarefa select type
        $this->addElement('select', 'instituicao_id', array(
            'label'      => 'Instituicao:',
            'multiOptions'  =>Application_Model_Instituicao::getOptions(),
            'required'   => true
        ));





        //adicionar fase de desenvolvimento
        //$fasesDesenvolvimento = new Application_Model_FasesDesenvolvimentos();
        //$todasFasesDesenvolvimento = $fasesDesenvolvimento->fetchAll();

        //$fasesDesenvolvimentoArray = array();
        //foreach ($todasFasesDesenvolvimento AS $row){
        //    $fasesDesenvolvimentoArray[$row->id] = $row->nome;
        //}

        /* Parte feita por Daniel */

        /* parte feito por Eduardo */

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Arquivo',
        ));
    }
}
