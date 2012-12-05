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
        $this->addElement('select', 'coordenador_tecnico', array(
            'label'      => 'Coordenador Técnico:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true
        ));

        //Gerência input type text
        $this->addElement('select', 'instituicao_gerencia_id', array(
            'label'      => 'Instituição de Gerência:',
            'multiOptions' => Application_Model_InstituicaoGerencia::getOptions(),
            'required'   => true
        ));

        //Gerente input type text
        $this->addElement('select', 'gerente', array(
            'label'      => 'Gerente do Projeto:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true
        ));

        //Criador input type text
        $this->addElement('select', 'criador', array(
            'label'      => 'Criador:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
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

        $this->addElement('select', 'projeto_tipo_id', array(
            'label'      => 'Tipo de Projeto:',
            'multiOptions' => Application_Model_ProjetoTipo::getOptions(),
            'required'   => true
        ));

        //modo de contratação

        $this->addElement('select', 'modo_contratacao_id', array(
            'label'      => 'Modo de Contratação:',
            'multiOptions' => Application_Model_ModoContratacao::getOptions(),
            'required'   => true
        ));

        //Categoria de Financiador (publico, privado, rec. prop)
        $this->addElement('select', 'categoria_financiador_id', array(
            'label'      => 'Categoria Financiador:',
            'multiOptions' => Application_Model_CategoriaFinanciador::getOptions(),
            'required'   => true
        ));

        //taxa fai
        $this->addElement('text', 'taxa_fai', array(
            'label'      => 'Taxa FAI:',
            'required'   => true
        ));

        //justificacao
        $this->addElement('text', 'justificativa', array(
            'label'      => 'Justificativa:',
            'required'   => true
        ));

        //Data de Início (Atual)
        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data_inicio');
        $emtDatePicker1->setLabel('Data de Início: ');
        $emtDatePicker1->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker1);

        //Data de Final Prevista
        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_final');
        $emtDatePicker2->setLabel('Data Final Prevista: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker2);

        //Data de Final Real
        $emtDatePicker3 = new ZendX_JQuery_Form_Element_DatePicker('data_final_real');
        $emtDatePicker3->setLabel('Data Final Real: ');
        $emtDatePicker3->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker3);



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
        $this->addElement('textarea', 'contrapartida_descricao', array(
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
                    'required'   => true
                ));

        //Horas Programadas input type tex(horas agendadas caso de uso)
        $this->addElement('text', 'horas_agendadas', array(
                    'label'      => 'Horas Agendadas:',
                    'required'   => true
                ));

        $this->addElement('select', 'estado_projeto_id', array(
            'label'      => 'Estado do Projeto:',
            'multiOptions' => Application_Model_EstadoProjeto::getOptions(),
            'required'   => true
        ));

        $this->addElement('textarea', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => true
        ));

        $this->addElement('select', 'prioridade_id', array(
            'label'      => 'Prioridade:',
            'multiOptions' => Application_Model_Prioridade::getOptions(),
            'required'   => true
        ));

        $this->addElement('text', 'prazo', array(
            'label'      => 'Prazo:',
            'required'   => true
        ));

        $this->addElement('text', 'resultados_esperados', array(
            'label'      => 'Resultados Esperados:',
            'required'   => true
        ));

        $this->addElement('text', 'escopo', array(
            'label'      => 'Escopo:',
            'required'   => true
        ));

        $this->addElement('text', 'nao_escopo', array(
            'label'      => 'Não Escopo:',
            'required'   => true
        ));

        $this->addElement('text', 'partes_interessadas', array(
            'label'      => 'Partes Interessadas:',
            'required'   => true
        ));

        $this->addElement('text', 'ligacoes', array(
            'label'      => 'Ligações:',
            'required'   => true
        ));

        $this->addElement('text', 'equipe', array(
            'label'      => 'Equipe:',
            'required'   => true
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
            'label'    => 'Enviar',
            ''
        ));


    }
}
