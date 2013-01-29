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

        $this->addElement('hidden', 'label_projeto', array(
            'description' => 'Detalhes',
            'ignore' => true,
            'order'          => 1,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Nome do projeto input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome da tarefa:',
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

//        $this->addElement('checkbox', 'marco_arquivo', array(
//            'label'      => 'Marco:',
//            'required'   => true
//        ));

        /*$emt = new ZendX_JQuery_Form_Element_AutoComplete('acTarefas');
        $emt->setLabel('Tarefa Superior:');
        $emt->setJQueryParam('data', Application_Model_Tarefa::getOptions2())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#tarefas-tarefa_id_pai").val(ui.item.id) }')
        ));
        $this->addElement($emt);*/

        $this->addElement('button', 'botaoPesquisa', array(
            'required' => false,
            'label'     => 'Pesquisar',
        ));

        $this->addElement('text', 'milestone', array(
            'label'      => 'Milestone:',
            'required'   => true,
        ));
        $this->addElement('text', 'dono', array(
            'label'      => 'Dono:',
            'required'   => true,
        ));
        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_inicio');
        $emtDatePicker->setLabel('Data de Início:');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        $emtDatePicker = new ZendX_JQuery_Form_Element_DatePicker('data_final');
        $emtDatePicker->setLabel('Data Final:');
        $emtDatePicker->setFilters(array('DateFilter'));

        $this->addElement($emtDatePicker);

        /*$this->addElement('text', 'data_inicio', array(
            'label'      => 'Data de Início:',
            'required'   => true,
        ));*/

        $this->addElement('text', 'duracao', array(
            'label'      => 'Duração:',
            'required'   => true,
        ));
        $this->addElement('select', 'tipo_duracao_id', array(
            'label'      => 'Tipo de Duração:',
            'multiOptions' => Application_Model_TipoDuracao::getOptions(),
            'required'   => true,
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



        $this->addElement('text', 'horas_trabalhadas', array(
            'label'      => 'Horas Trabalhadas:',
            'required'   => true,
        ));

        /*$this->addElement('text', 'data_final', array(
            'label'      => 'Data Final:',
            'required'   => true,
        ));*/

        $this->addElement('select', 'estado_tarefa_id', array(
            'label'      => 'Estado da tarefa:',
            'multiOptions' => Application_Model_EstadoTarefa::getOptions(),
            'required'   => true,
        ));
        $this->addElement('text', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => true,
        ));
        $this->addElement('text', 'orcamento_tarefa', array(
            'label'      => 'Orçamento da Tarefa:',
            'required'   => true,
        ));
        $this->addElement('text', 'website_relacionado', array(
            'label'      => 'Website Relacionado:',
            'required'   => true,
        ));

        //usuario logado?
        $this->addElement('text', 'criador', array(
            'label'      => 'Responsável:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true,
        ));
        $this->addElement('text', 'tarefa_dinamica', array(
            'label'      => 'Tarefa Dinâmica:',
            'required'   => true,
        ));

        $this->addElement('select', 'acesso_id', array(
            'label'      => 'Acesso:',
            'multiOptions' => Application_Model_Acesso::getOptions(),
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
        $this->addElement('select', 'tipo_tarefa_id', array(
            'label'      => 'Tipo de tarefa:',
            'multiOptions' => Application_Model_TipoTarefa::getOptions(),
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
