<?php

class Application_Form_PastaArquivos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('pasta_arquivo');

        // Setar metodo
        $this->setMethod('post');

        //sub pasta de:
        $this->addElement('select', 'pasta_arquivo_pae', array(
            'label'      => 'Sub Pasta de:',
            'multiOptions' => array('raiz'=>'raiz'),
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
