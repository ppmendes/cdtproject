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

        //Código - Natureza da Despesa
        $this->addElement('select', 'codigo_natureza_despesa', array(
            'label'      => 'Código - Natureza da Despesa:',
            'multiOptions' => Application_Model_Rubrica::getOptions(),
            'required'   => true,
        ));

        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Autocomplete');
        $emt->setJQueryParam('data', Application_Model_Rubrica::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
                             'function(event,ui) { $("#orcamento-autoid").val(ui.item.id) }')
            ));
        $this->addElement($emt);

        //set hidden
        $this->addElement('hidden', 'autoid', array(
            'value'      => ''
        ));

        //descrição
        $this->addElement('text', 'descricao', array(
            'label'      => 'Descrição:',
            'required'   => true,
        ));


        //finalidade
        $this->addElement('textarea', 'finalidade', array(
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
    }
}
