<?php

class Application_Form_Projetos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('projetos');

        // Setar metodo
        $this->setMethod('post');

        //Nome do projeto input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome do projeto:',
            'required'   => true,
        ));

        //Apelido do projeto input type text
        $this->addElement('text', 'apelido', array(
            'label'      => 'Apelido do Projeto:',
            'required'   => true
        ));

        //Coordenador do projeto input type text
        $this->addElement('text', 'coordenador_tecnico', array(
            'label'      => 'Coordenador Técnico:',
            'required'   => true
        ));

        //Gerência input type text
        $this->addElement('text', 'gerencia', array(
            'label'      => 'Gerência:',
            'required'   => true
        ));

        //Gerente input type text
        $this->addElement('text', 'gerente', array(
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

        $array_tipo_projeto = array(
            1 => 'Apoio a Graduação',
            2 => 'Apoio a Treinamentos, Workshop\'s e Eventos',
            3 => 'Consultorias Técnicas',
            4 => 'Cursos de capacitação técnica e científica',
            5 => 'Depósitos de Patentes',
            6 => 'Pesquisa, Desenvolvimento &amp; Inovação',
            7 => 'Programas de Desenvolvimento Tecnológico e Empreendedorismo',
            8 => 'Projetos de Laboratórios',
            9 => 'Projetos de Departamentos',
            10 => 'Serviços Tecnológicos',
            11 => 'Programas de Apoio Administrativo',
        );
		
		$this->addElement('select', 'projeto_tipo_id', array(
            'label'      => 'Tipo de Projeto:',
			'multiOptions'  => $array_tipo_projeto,
            'required'   => true
        ));

        /* Parte feita por Daniel */

        //Orçamento previsto input type text
        $this->addElement('text', 'orcamento', array(
            'label'      => 'Orçamento Previsto:',
            'required'   => true
        ));

        //Contrapartida input input type text
        $this->addElement('text', 'contrapartida', array(
            'label'      => 'Contrapartida:',
            'required'   => true
        ));

        //Descrição da Contrapartida (TAP)
        $this->addElement('text', 'contrapartida_descricao', array(
            'label'      => 'Descrição da Contrapartida:',
            'required'   => true
        ));

        //Valor Total do projeto (vai ser Orçamento mais contrapartida)
        $this->addElement('text', 'valor_total_projeto', array(
            'label'      => 'Valor Total:',
            'required'   => true
        ));

        //CCO do orçamento input type text  editavel (não tem regra)
        $this->addElement('text', 'orcamento_CCO', array(
            'label'      => 'CCO do orçamento (% CDT):',
            'required'   => true
        ));

        /* parte feito por Eduardo */

        //Descrição da CCO input type textarea
        $this->addElement('textarea', 'descricao_CCO', array(
                    'label'      => 'Descrição da CCO:',
                    'required'   => true
        ));

        //Horas trabalhadas input type text
        $this->addElement('text', 'horas_trabalhadas', array(
                    'label'      => 'Horas trabalhadas:',
                    'required'   => false
                ));

        //Horas Programadas input type tex(horas agendadas caso de uso)
        $this->addElement('text', 'horas_programadas', array(
                    'label'      => 'Horas Programadas:',
                    'required'   => false
                ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Projeto',
        ));

    }
}
