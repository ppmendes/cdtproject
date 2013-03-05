<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ppmendes
 * Date: 05/10/12
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */

class Application_Form_Orcamentos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('orcamento');

        // Setar metodo
        $this->setMethod('post');

        //descricao, finalidade, valor,  destinatário

        //Projeto
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto:',
            'required'   => true,
        ));

        //Código - Natureza da Despesa - Rubrica
        $this->addElement('text', 'rubrica', array(
            'label'      => 'Rúbrica (Código - Descrição):',
            'required'   => true,
        ));

        //descrição
        $this->addElement('text', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => true,
        ));


        //finalidade
        $this->addElement('text', 'finalidade', array(
            'label'      => 'Finalidade:',
            'required'   => true,
        ));

        //valor
        $this->addElement('text', 'valor', array(
            'label'      => 'Valor:',
            'required'   => true
        ));

        //destinatário
        $this->addElement('select', 'destinatario', array(
            'label'      => 'Destinatário:',
            'class'      => 'combobox ui-widget',
            'multiOptions' => Application_Model_Destino::getOptions(),
            'required'   => true
        ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Inserir',
        ));

        //set hidden
        $this->addElement('hidden', 'rubrica_id', array(
            'value'      => ''
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => ''
        ));
    }
}
