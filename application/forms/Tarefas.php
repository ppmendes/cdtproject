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

    private $data_inicio;
    private $data_final;
    private $tipo_duraco;


    public function setDatas($dat_inic_controller,$dat_fin_controller,$tipo_duracao_controller)
    {
        $this->data_inicio=$dat_inic_controller;
        $this->data_final=$dat_fin_controller;
        $this->tipo_duraco=$tipo_duracao_controller;
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

        //prioridade da tarefa select type
        $this->addElement('select', 'prioridade_id', array(
            'label'      => 'Prioridade:',
            'multiOptions'  => Application_Model_Prioridade::getOptions(),
            'required'   => true
        ));

        // array para progresso da tarefas
        $array_progresso_tarefa = array(
            1 => '0',
            2 => '5',
            3 => '10',
            4 => '15',
            5 => '20',
            6 => '25',
            7 => '30',
            8 => '35',
            9 => '40',
            10 => '45',
            11 => '50',
            12 => '55',
            13 => '60',
            14 => '65',
            15 => '70',
            16 => '75',
            17 => '80',
            18 => '85',
            19 => '90',
            20 => '95',
            21 => '100',
        );

        //progresso da tarefa select type
        $this->addElement('select', 'percentagem_completo', array(
            'label'      => 'Porcentagem Completa:',
            'multiOptions'  => $array_progresso_tarefa,
            'required'   => true
        ));



    /***************************** LABEL DETALHES *********************************/
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

        $this->addElement('text', 'dono', array(
            'label'      => 'Responsável da tarefa:',
            'required'   => true,
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
    /******************************** LABEL DATAS **************************************/
        $this->addElement('hidden', 'label_datas', array(
            'description' => 'Datas',
            'ignore' => true,
            'decorators' => array(
            array('Description', array('escape'=>false)),
            ),
        ));

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_inicio');
        $emtDatePicker->setLabel('Data de Início:');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_final');
        $emtDatePicker->setLabel('Data Final:');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $this->addElement('select', 'tipo_duracao_id', array(
            'label'      => 'Tipo de Duração:',
            'multiOptions' => Application_Model_TipoDuracao::getOptions(),
            'required'   => true,
        ));

        $this->addElement('text', 'duracao', array(
            'label'      => 'Duração:',
            'required'   => true,
        ));

        $this->addElement('text', 'horas_trabalhadas', array(
            'label'      => 'Horas Trabalhadas:',
            'required'   => true,
        ));

        $array_horas_trabalhadas = array(
            1 => '06',
            2 => '07',
            3 => '08',
            4 => '09',
            5 => '10',
            6 => '11',
            7 => '12',
            8 => '13',
            9 => '14',
            10 => '15',
            11 => '16',
            12 => '17',
            13 => '18',
            14 => '19',
            15 => '20',
            16 => '21',
            17 => '22',
        );

        $this->addElement('select', 'hora_inicio', array(
            'label'      => 'Hora inicio:',
            'multiOptions'  => $array_horas_trabalhadas,
            'required'   => true
        ));

        $this->addElement('select', 'hora_fim', array(
            'label'      => 'Hora fim:',
            'multiOptions'  => $array_horas_trabalhadas,
            'required'   => true
        ));

        $this->addElement('button', 'botaoDuracao', array(
            'required' => false,
            'label'     => 'Duração',
            'attribs' => array('onClick' => 'calcularDias($this->data_inicio, $this->data_final, $this->tipo_duraco)'),
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
            'multiOptions' => Application_Model_Tarefa::getOptions(),
            'required'   => false,
        ));
        $this->addElement('button', 'botao_Adicionar_Tarefa', array(
            'required' => false,
            'label'     => '>',
        ));

        $this->addElement('button', 'botao_Deletar_Tarefa', array(
            'required' => false,
            'label'     => '<',
        ));

        $this->addElement('multiselect', 'dependencia_tarefa', array(
            'label'      => 'Dependencias das Tarefas:',
            'required'   => false,
        ));



        /******************************** LABEL RECURSOS HUMANOS **************************************/
        $this->addElement('hidden', 'recursos_humanos', array(
            'description' => 'Recursos Humanos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('multiselect', 'recusrsos_humanos', array(
            'label'      => 'Recursos Humanos:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => false,
        ));
        $this->addElement('button', 'botaoAdicionarRH', array(
            'required' => false,
            'label'     => '>',
        ));
        $this->addElement('select', 'percentagem_trabalho', array(
            'label'      => 'Porcentagem Completa:',
            'multiOptions'  => $array_progresso_tarefa,
            'required'   => true
        ));
        $this->addElement('button', 'botaoDeletarRH', array(
            'required' => false,
            'label'     => '<',
        ));

        $this->addElement('multiselect', 'asociado_tarefa', array(
            'label'      => 'Asociado a Tarefa:',
            'required'   => false,
        ));
        $this->addElement('textarea', 'comentario_email', array(
            'label'      => 'Comentários Adicionais do E-mail:',
            'required'   => false,
        ));
        $this->addElement('checkbox', 'notificar_email', array(
            'label'      => 'Notificar associados da tarefa por e-mail:',
            'required'   => true,
        ));

        /******************************** LABEL OUTROS RECURSOS **************************************/
        $this->addElement('hidden', 'outros', array(
            'description' => 'Outros Recursos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));



        $this->addElement('text', 'milestone', array(
            'label'      => 'Milestone:',
            'required'   => true,
        ));

        //usuario logado?
        $this->addElement('text', 'criador', array(
            'label'      => 'Responsável:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true,
        ));
        /*$this->addElement('text', 'acesso_id', array(
            'label'      => 'Acesso:',
            'required'   => true,
        ));*/

        $this->addElement('text', 'tarefa_notificacao', array(
            'label'      => 'Notificação:',
            'required'   => true,
        ));


        /*$this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto:',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true,
        ));*/

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Projeto:');
        $emt->setJQueryParam('data', Application_Model_Projeto::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#tarefas-autoid").val(ui.item.id) }')
        ));
        $this->addElement($emt);

        $this->addElement('select', 'instituicao_id', array(
            'label'      => 'Area:',
            'multiOptions' => Application_Model_Instituicao::getOptions(),
            'required'   => true,
        ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Tarefa',
        ));

        //set hidden projeto
        $this->addElement('hidden', 'autoid', array(
            'value'      => ''
        ));

        //set hidden projeto
        $this->addElement('hidden', 'tarefa_id_pai', array(
            'value'      => ''
        ));
    }
}
