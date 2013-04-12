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

    private $valorParcelas;
    private $id_projeto;

    public function setValorParcelas($valor){
        $this->valorParcelas = $valor;
    }

    public function setProjetoId($id_projeto){
        $this->id_projeto = $id_projeto;
    }

    public function init() {}

    public function startform()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('orcamento');

        // Setar metodo
        $this->setMethod('post');

        //descricao, finalidade, valor,  destinatário

        //Projeto
        $nomeProjeto = Application_Model_Projeto::getNome($this->id_projeto);
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto:',
            'value'      => $nomeProjeto['0']['nome'],
            'required'   => true,
            'readonly'   => true,
            'ignore'     => true,
        ));

        $orcamento = Application_Model_Projeto::getValorOrcamento($this->id_projeto);
        $valorLimite = number_format($orcamento['0']['orcamento'] - $this->valorParcelas, 2, ',', '.');


//        $this->addElement('text', 'saldo', array(
//            'label'     => 'Saldo Atual:',
//            'value'     => $valorLimite,
//            'readonly'  => true,
//            'required'  => false,
////            'attribs'    => array('maxLength' => 13),
////            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
//        ));

        //Código - Natureza da Despesa - Rubrica
        $this->addElement('text', 'rubrica', array(
            'label'      => 'Rúbrica (Código - Descrição):',
            'required'   => true,
        ));

        //descrição
        $this->addElement('text', 'descricao_orcamento', array(
            'label'      => 'Descrição:',
            'required'   => true,
        ));


        //finalidade
        $this->addElement('text', 'objetivo_orcamento', array(
            'label'      => 'Finalidade:',
            'required'   => true,
        ));


        //valor

        $this->addElement('text', 'valor_orcamento', array(
            'label'      => 'Valor:',
            'required'   => true,
            'attribs'    => array('maxLength' => 13),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
        ));

        //$elemento = $this->getElement('valor_orcamento');
        //$elemento->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => $valorLimite)));

        //destinatário
        $this->addElement('select', 'destinatario_id', array(
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
            'value'      => $this->id_projeto,
        ));

    }
}
