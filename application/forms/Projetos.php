<?php

class Application_Form_Projetos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
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

        //Criador input type text
        $this->addElement('text', 'criador', array(
            'label'      => 'Criador:',
            'required'   => true
        ));
		
		//adicionar fase de desenvolvimento
		//$fasesDesenvolvimento = new Application_Model_FasesDesenvolvimentos();
        //$todasFasesDesenvolvimento = $fasesDesenvolvimento->fetchAll();

        //$fasesDesenvolvimentoArray = array();
        //foreach ($todasFasesDesenvolvimento AS $row){
        //    $fasesDesenvolvimentoArray[$row->id] = $row->nome;
        //}

        //instituição
//        $this->addElement('text', 'instituicao', array(
//            'label'      => 'Instituição:',
//            'required'   => true
//        ));

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

        //modo de contratação
        $array_modo_contratacao = array(
            1 => 'Contratos',
            2 => 'Convênios',
            3 => 'Consultorias Técnicas',
            4 => 'Termos de Cooperação',
            5 => 'Projetos Internos',
            6 => 'Programação de Apoio Administrativo',
        );

        $this->addElement('select', 'modo_contratacao_id', array(
            'label'      => 'Modo de Contratação:',
            'multiOptions'  => $array_modo_contratacao,
            'required'   => true
        ));

        //Categoria de Financiador (publico, privado, rec. prop)
        $array_categoria_financiadora = array(
            1 => 'Público',
            2 => 'Privado',
            3 => 'Recursos Próprios',
        );

        $this->addElement('select', 'categoria_financiador_id', array(
            'label'      => 'Categoria de Financiador:',
            'multiOptions'  => $array_categoria_financiadora,
            'required'   => true
        ));

        //taxa fai
        $this->addElement('text', 'taxa_fai', array(
            'label'      => 'Taxa FAI:',
            'required'   => true
        ));

        //justificacao
        $this->addElement('text', 'justificacao', array(
            'label'      => 'Justificação:',
            'required'   => true
        ));

        //Data de Início (Atual)
        $this->addElement('text', 'data_inicio', array(
            'label'      => 'Data de Início:',
            'required'   => true
        ));

        //Data de Final Prevista
        $this->addElement('text', 'data_final', array(
            'label'      => 'Data Final:',
            'required'   => true
        ));

        //Data de Final Real
        $this->addElement('text', 'data_final_real', array(
            'label'      => 'Data Final Real:',
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

//        //Valor Total do projeto (vai ser Orçamento mais contrapartida)
//        $this->addElement('text', 'valor_total_projeto', array(
//            'label'      => 'Valor Total:',
//            'required'   => true
//        ));

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
        $this->addElement('text', 'horas_agendadas', array(
                    'label'      => 'Horas Agendadas:',
                    'required'   => false
                ));

        $this->addElement('text', 'estado_projeto_id', array(
            'label'      => 'Estado do Projeto:',
            'required'   => false
        ));

        $this->addElement('text', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => false
        ));

        $this->addElement('text', 'prioridade_id', array(
            'label'      => 'Prioridade:',
            'required'   => false
        ));

        $this->addElement('text', 'prazo', array(
            'label'      => 'Prazo:',
            'required'   => false
        ));

        $this->addElement('text', 'resultados_esperados', array(
            'label'      => 'Resultados Esperados:',
            'required'   => false
        ));

        $this->addElement('text', 'escopo', array(
            'label'      => 'Escopo:',
            'required'   => false
        ));

        $this->addElement('text', 'nao_escopo', array(
            'label'      => 'Não Escopo:',
            'required'   => false
        ));

        $this->addElement('text', 'partes_interessadas', array(
            'label'      => 'Partes Interessadas:',
            'required'   => false
        ));

        $this->addElement('text', 'ligacoes', array(
            'label'      => 'Ligações:',
            'required'   => false
        ));

        $this->addElement('text', 'equipe', array(
            'label'      => 'Equipe:',
            'required'   => false
        ));

        $this->addElement('text', 'website', array(
            'label'      => 'Website:',
            'required'   => false
        ));

        $this->addElement('text', 'percentagem_completo', array(
            'label'      => 'Porcentagem Completo:',
            'required'   => false
        ));

        $this->addElement('text', 'color_identificador', array(
            'label'      => 'Cor identificadora:',
            'required'   => false
        ));

        $this->addElement('text', 'orcamento_atual', array(
            'label'      => 'Orçamento Atual:',
            'required'   => false
        ));

        $this->addElement('text', 'premissas', array(
            'label'      => 'Premissas:',
            'required'   => false
        ));

        $this->addElement('text', 'restricoes', array(
            'label'      => 'Restrições:',
            'required'   => false
        ));

        $this->addElement('text', 'metas', array(
            'label'      => 'Metas:',
            'required'   => false
        ));

        //teste upload
//        $this->addElement('file', 'teste_upload', array(
//            'label'      => 'Teste Upload:',
//            'required'   => false
//        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Projeto',
        ));


    }
}
