<?php

class Application_Form_Projetos extends Zend_Form
{

    public function init()
    {
        // Setar metodo
        $this->setMethod('post');

        //Nome do projeto input type text
        $this->addElement('text', 'projeto_nome', array(
            'label'      => 'Nome do projeto:',
            'required'   => true            
        ));

        //Apelido do projeto input type text
        $this->addElement('text', 'projeto_apelido', array(
            'label'      => 'Apelido do Projeto:',
            'required'   => true
        ));

        //Coordenador do projeto input type text
        $this->addElement('text', 'projeto_coordenador_tecnico', array(
            'label'      => 'Coordenador Técnico:',
            'required'   => true
        ));

        //Gerência input type text
        $this->addElement('text', 'projeto_gerencia', array(
            'label'      => 'Gerência:',
            'required'   => true
        ));

        //Gerente input type text
        $this->addElement('text', 'projeto_gerente', array(
            'label'      => 'Gerente do Projeto:',
            'required'   => true
        ));
		
		//adicionar fase de desenvolvimento
		//$fasesDesenvolvimento = new Application_Model_FasesDesenvolvimentos();
        //$todasFasesDesenvolvimento = $fasesDesenvolvimento->fetchAll();

        //$fasesDesenvolvimentoArray = array();
        //foreach ($todasFasesDesenvolvimento AS $row){
        //    $fasesDesenvolvimentoArray[$row->id] = $row->nome;
        //}
		
		//$this->addElement('select', 'fases_desenvolvimentos_id', array(
        //    'label'      => 'Titulo Solucao Tecnologica:',
		//	'multiOptions'  => $fasesDesenvolvimentoArray,
        //    'required'   => true
        //
        //));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Solucao',
        ));

    }
}
