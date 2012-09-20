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
        $array_pasta_arquivo = array(
            1 => 'Raiz',

        );

        //situação da tarefa select type
        $this->addElement('select', 'pasta', array(
            'label'      => 'Pasta:',
            'multiOptions'  => $array_pasta_arquivo,
            'required'   => true
        ));

        //versao do arquivo input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Versão:',
            'required'   => true,
        ));

        // array para atributo tipo de arquivo
        $array_tipo_arquivo = array(
            1 => 'Desconhecido',
            2 => 'Documento',
            3 => 'Aplicativo',
        );

        //tipo de arquivo select type
        $this->addElement('select', 'tipo', array(
            'label'      => 'Tipo de Arquivo:',
            'multiOptions'  => $array_tipo_arquivo,
            'required'   => true
        ));

        //tarefa input type text
        $this->addElement('text', 'nome_tarefa', array(
            'label'      => 'Tarefa:',
            'required'   => true,
        ));

        //descriçao do arquivo input type textarea
        $this->addElement('textarea', 'descricao_arquivo', array(
            'label'      => 'Descrição:',
            'required'   => true
        ));

        $this->addElement('file', 'teste_upload', array(
            'label'      => 'Teste Upload:',
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
