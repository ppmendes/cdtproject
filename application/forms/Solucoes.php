<?php

class Application_Form_Projetos extends Zend_Form
{

    public function init()
    {
        // Setar metodo
        $this->setMethod('post');

        // Adicionar nome
        $this->addElement('textarea', 'nome', array(
            'label'      => 'Titulo Solucao Tecnologica:',
            'required'   => true            
        ));
		
		//adicionar fase de desenvolvimento
		$fasesDesenvolvimento = new Application_Model_FasesDesenvolvimentos();
        $todasFasesDesenvolvimento = $fasesDesenvolvimento->fetchAll();

        $fasesDesenvolvimentoArray = array();
        foreach ($todasFasesDesenvolvimento AS $row){
            $fasesDesenvolvimentoArray[$row->id] = $row->nome;
        }
		
		$this->addElement('select', 'fases_desenvolvimentos_id', array(
            'label'      => 'Titulo Solucao Tecnologica:',			
			'multiOptions'  => $fasesDesenvolvimentoArray,
            'required'   => true
            
        ));	

        // Adicionar descri��o problema
        $this->addElement('textarea', 'descricao_problema', array(
            'label'      => 'Descricao do Problema:',
            'required'   => true,            
        ));
		
		// Adicionar descri��o problema
        $this->addElement('textarea', 'descricao_tecnologia_solucao', array(
            'label'      => 'Descricao da Tecnlogia e Soluao Proposta:',
            'required'   => true,            
        ));
		
		//palavras-chaves
		$this->addElement('text', 'palavras_chaves', array(
            'label'      => 'Palavras-chaves:',
            'required'   => true,            
        ));
		
		//oportunidades
		
		//campo de aplica��o
		
		//deposito, titular
		
		//modalidade de proteção		

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Solucao',
        ));
		
		

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}
