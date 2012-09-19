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

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('tarefas');

        // Setar metodo
        $this->setMethod('post');

        //Nome do projeto input type text
        $this->addElement('text', 'nome', array(
            'label'      => 'Nome da tarefa:',
            'required'   => true,
        ));

        // array para atributo situação
        $array_situacao_tarefa = array(
            1 => 'Ativa',
            2 => 'Inativo(a)',
        );

        //situação da tarefa select type
        $this->addElement('select', 'situacao', array(
            'label'      => 'Situação:',
            'multiOptions'  => $array_situacao_tarefa,
            'required'   => true
        ));

        // array para prioridade da tarefas
        $array_prioridade_tarefa = array(
            1 => 'Normal',
            2 => 'Baixa',
            3 => 'Alta',
        );

        //prioridade da tarefa select type
        $this->addElement('select', 'prioridade', array(
            'label'      => 'Prioridade:',
            'multiOptions'  => $array_prioridade_tarefa,
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
        $this->addElement('select', 'progresso', array(
            'label'      => 'Progresso:',
            'multiOptions'  => $array_progresso_tarefa,
            'required'   => true
        ));

        //adicionar fase de desenvolvimento
        //$fasesDesenvolvimento = new Application_Model_FasesDesenvolvimentos();
        //$todasFasesDesenvolvimento = $fasesDesenvolvimento->fetchAll();

        //$fasesDesenvolvimentoArray = array();
        //foreach ($todasFasesDesenvolvimento AS $row){
        //    $fasesDesenvolvimentoArray[$row->id] = $row->nome;
        //}

        /* Parte feita por Daniel */

        /* parte feito por Eduardo */

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir Tarefa',
        ));
    }
}
