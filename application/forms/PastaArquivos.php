<?php

class Application_Form_PastaArquivos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('pasta_arquivos');

        // Setar metodo
        $this->setMethod('post');

        /*$this->addElement('text', 'pasta_arquivo_id', array(
            'label'      => 'Pasta ID:',
            'required'   => true
        ));*/

        //sub pasta de:
        $this->addElement('select', 'pasta_arquivo_pae', array(
            'label'      => 'Sub Pasta de:',
            'multiOptions' => Application_Model_PastaArquivo::getOptions(),
            'required'   => true
        ));

        //Nome da pasta:
        $this->addElement('text', 'nome_pasta', array(
            'label'      => 'Nome da Pasta:',
            'required'   => true
        ));

        //descrição pasta
        $this->addElement('text', 'descricao_pasta', array(
            'label'      => 'Descrição Pasta:',
            'required'   => true
        ));

        // nome do projeto
        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Nome do Projeto:',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true
        ));

        // nome da tarefa
        $this->addElement('select', 'tarefa_id', array(
            'label'      => 'Nome da Tarefa:',
            'multiOptions' => Application_Model_Tarefa::getOptions1(),
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));
    }
}
