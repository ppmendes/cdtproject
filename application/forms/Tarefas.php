<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Harley
 * Date: 19/09/12
 * Time: 15:30
 * To change this template use File | Settings | File Templates.
 */
class Application_Form_Tarefas extends Zend_Form
{

    private $id_projeto;
    private $id_tarefa;


    public function setIdProjeto($id_projeto_controller){
        $this->id_projeto = $id_projeto_controller;
    }

    public function setIdTarefa($id_tarefa_controller){
        $this->id_tarefa = $id_tarefa_controller;
    }

    public function startform()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('tarefas');
        $this->setAttrib('enctype', 'multipart/form-data');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Tarefas',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));
        
        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Projeto:');
        $emt->setRequired(true);
        $emt->setJQueryParam('data', Application_Model_Projeto::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#tarefas-projeto_id").val(ui.item.id); atualizarUsuarios(ui.item.id); atualizarTarefas(ui.item.id); atualizarTarefas1(ui.item.id)}')
        ));
        $this->addElement($emt);
        
       /* $nomeProjeto = Application_Model_Projeto::getNome($this->id_projeto);
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto:',
            'value'      => $nomeProjeto['0']['nome'],
            'required'   => true,
            'readonly'   => true,
            'ignore'     => true,
        )); */


        //Nome do projeto input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome da tarefa:',
            'required'   => true,
        ));

        //progresso da tarefa select type
        $this->addElement('select', 'estado_tarefa_id', array(
            'label'      => 'Situação da tarefa:',
            'multiOptions' => Application_Model_EstadoTarefa::getOptions(),
            'required'   => true,
        ));
        //
        //prioridade da tarefa select type
        $this->addElement('select', 'prioridade_id', array(
            'label'      => 'Prioridade:',
            'multiOptions'  => Application_Model_Prioridade::getOptions(),
            'required'   => true
        ));

        // array para progresso da tarefas
        $array_progresso_tarefa = array(
            0 => '0',
            5 => '5',
            10 => '10',
            15 => '15',
            20 => '20',
            25 => '25',
            30 => '30',
            35 => '35',
            40 => '40',
            45 => '45',
            50 => '50',
            55 => '55',
            60 => '60',
            65 => '65',
            70 => '70',
            75 => '75',
            80 => '80',
            85 => '85',
            90 => '90',
            95 => '95',
            100 => '100',
        );

        //progresso da tarefa select type
        $this->addElement('select', 'percentagem_completo', array(
            'label'      => 'Porcentagem Completa:',
            'multiOptions'  => $array_progresso_tarefa,
            'required'   => true
        ));



        /***************************** LABEL DETALHES **00*******************************/
        $this->addElement('hidden', 'label_projeto', array(
            'description' => 'Detalhes',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('select', 'tipo_tarefa_id', array(
            'label'      => 'Tipo de tarefa:',
            'multiOptions' => Application_Model_TipoTarefa::getOptions(),
            'required'   => true,
        ));

        $this->addElement('select', 'acesso_id', array(
            'label'      => 'Acesso:',
            'multiOptions' => Application_Model_Acesso::getOptions(),
            'required'   => true,
        ));

        $this->addElement('select', 'dono', array(
            'label'      => 'Responsável da tarefa:',
            'required'   => true,
            'multiOptions'=>Application_Model_Usuario::getOptions1($this->id_projeto),
            'RegisterInArrayValidator'=>false,
        ));

        $this->addElement('text', 'website_relacionado', array(
            'label'      => 'Website Relacionado:',
            'required'   => true,
        ));

        $this->addElement('text', 'orcamento_tarefa', array(
            'label'      => 'Orçamento da Tarefa:',
            'required'   => true,
        ));

        $this->addElement('textarea', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => true,
        ));

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('aca');
        $emt->setLabel('Area:');
        $emt->setJQueryParam('data', Application_Model_Instituicao::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#tarefas-instituicao_id").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        $this->addElement('button', 'botaoPesquisa', array(
            'required' => false,
            'label'     => 'Pesquisar',
        ));

        $this->addElement('select', 'tarefa_id_pai', array(
            'label'      => 'Tarefa Pai:',
            'multiOptions' => Application_Model_Tarefa::getOptions1($this->id_projeto),
            'required'   => false,
            'RegisterInArrayValidator'=>false
        ));
        /******************************** LABEL DATAS **************************************/
        $this->addElement('hidden', 'label_datas', array(
            'description' => 'Datas',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_inicio');
        $emtDatePicker->setLabel('Data Início:');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_final');
        $emtDatePicker->setLabel('Data Término:');
        $emtDatePicker->setFilters(array('DateFilter'));
        $emtDatePicker->setAttribs(array('onchange' => 'validarDatas()'));


        $this->addElement($emtDatePicker);

        //var_dump($emtDatePicker);

        $array_tipo_duracao = array(
            1 => 'Horas',
            2 => 'Dias',
        );//

        $this->addElement('select', 'tipo_duracao_id', array(
            'label'      => 'Tipo de Duração:',
            'multiOptions' => $array_tipo_duracao,
            'required'   => true,
            'value' => 2,
        ));

        $this->addElement('text', 'duracao', array(
            'label'      => 'Duração Esperada:',
            'required'   => true,
        ));

        $array_horas_trabalhadas = array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',

        );//


        $this->addElement('select', 'horas_trabalhadas', array(
            'label'      => 'Horas Diárias de Atividade:',
            'multiOptions'  => $array_horas_trabalhadas,
            'value'=>8,
            'required'   => true
        ));


        $this->addElement('button', 'botaoDuracao', array(
            'required' => false,
            'label'     => 'Duração',
        ));

        $this->addElement('button', 'botaoDataEncerramento', array(
            'required' => false,
            'label'     => 'Data de Encerramento',
        ));
        /******************************** LABEL DEPENDENCIAS **************************************/
        $this->addElement('hidden', 'dependencias', array(
            'description' => 'Dependencias',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('checkbox', 'tarefa_dinamica', array(
            'label'      => 'Tarefa Dinâmica:',
            'required'   => true,
        ));

        $this->addElement('multiselect', 'todas_tarefas', array(
            'label'      => 'Todas as Tarefas:',
            'multiOptions' => Application_Model_Tarefa::getOptions3($this->id_projeto,$this->id_tarefa),
            'required'   => false,
            'size'=>10,
        ));

        $this->addElement('button', 'botao_Adicionar_Tarefa', array(
            'required' => false,
            'label'     => '>>',
        ));

        $this->addElement('button', 'botao_Deletar_Tarefa', array(
            'required' => false,
            'label'     => '<<',
        ));

        $this->addElement('multiselect', 'dependencia_tarefa', array(
            'label'      => 'Dependencias das Tarefas:',
            'required'   => false,
            'size'=>10,
            'multiOptions' => Application_Model_TarefasDependentes::getOptions($this->id_tarefa),
            'RegisterInArrayValidator'=>false,

        ));

        /******************************** LABEL RECURSOS HUMANOS **************************************/
        $this->addElement('hidden', 'recursos_humano', array(
            'description' => 'Recursos Humanos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('multiselect', 'recursos_humanos', array(
            'label'      => 'Recursos Humanos:',
            'multiOptions' => Application_Model_Usuario::getOptions2($this->id_projeto,$this->id_tarefa),
            'required'   => false,
        ));

        $this->addElement('button', 'botaoAdicionarRH', array(
            'required' => false,
            'label'     => '>>',
        ));

        $this->addElement('select', 'percentagem_trabalho', array(
            'label'      => 'Porcentagem Completa:',
            'multiOptions'  => $array_progresso_tarefa,
            'required'   => true
        ));

        $this->addElement('button', 'botaoDeletarRH', array(
            'required' => false,
            'label'     => '<<',
        ));

        $this->addElement('multiselect', 'asociado_tarefa', array(
            'label'      => 'Asociado a Tarefa:',
            'required'   => false,
            'multiOptions' => Application_Model_UsuariosAssociadosTarefa::getOptions($this->id_tarefa),
            'RegisterInArrayValidator'=>false,
        ));

        /*$this->addElement('textarea', 'comentario_email', array(
            'label'      => 'Comentários Adicionais do E-mail:',
            'required'   => false,
        ));

        $this->addElement('checkbox', 'tarefa_notificacao', array(
            'label'      => 'Notificar associados da tarefa por e-mail:',
            'required'   => true,
        ));*/

        /******************************** LABEL OUTROS RECURSOS **************************************/
        $this->addElement('hidden', 'outros', array(
            'description' => 'Outros Recursos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('multiselect', 'outros_recursos', array(
            'label'      => 'Outros Recursos:',
            'multiOptions' => Application_Model_Rubrica::getOptions2(),
            'required'   => false,
        ));

        $this->addElement('button', 'botaoAdicionarOR', array(
            'required' => false,
            'label'     => '>>',
        ));

        $this->addElement('select', 'percentagem_recurso', array(
            'label'      => 'Porcentagem Completa:',
            'multiOptions'  => $array_progresso_tarefa,
            'required'   => true
        ));

        $this->addElement('button', 'botaoDeletarOR', array(
            'required' => false,
            'label'     => '<<',
        ));

        $this->addElement('multiselect', 'asociado_tarefa1', array(
            'label'      => 'Asociado a Tarefa:',
            'required'   => false,
            'multiOptions' => Application_Model_RubricaAssociadaTarefa::getOptions($this->id_tarefa),
            'RegisterInArrayValidator'=>false,
        ));

        // Add the submit button90
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Tarefa',
        ));

        
        //set hidden projeto
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $this->id_projeto,
        ));

        $this->addElement('hidden', 'instituicao_id', array(
            'value'      => ''
        ));

    }
}