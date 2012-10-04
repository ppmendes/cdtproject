<?php
//descricao	text
//
//4		varchar(45)
//5		text
//6		date
//7		int(11)
//8		int(11)
//9		int(11)
//10		decimal(10,2)
//11		int(11)
//12		date
//13		date
//14		int(11)
//15		int(11)
//16
class Application_Form_Empenhos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        //$this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('empenhos');

        // Setar metodo
        $this->setMethod('post');

        //input type text
        $this->addElement('text', 'descricao', array(
            'label'      => 'descricao',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'processo_administrativo', array(
            'label'      => 'processo_administrativo',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'historico', array(
            'label'      => 'historico',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'data', array(
            'label'      => 'data',
            'required'   => true,
        ));

        $this->addElement('select', 'beneficiario_id', array(
            'label'      => 'beneficiario_id',
            'multiOptions' => Application_Model_Beneficiario::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'projeto_id', array(
            'label'      => 'projeto_id',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'tarefa_id', array(
            'label'      => 'tarefa_id',
            'multiOptions' => Application_Model_Tarefa::getOptions(),
            'required'   => true
        ));

        //input type text
        $this->addElement('text', 'valor_empenho', array(
            'label'      => 'valor_empenho',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'numero_parcelas', array(
            'label'      => 'numero_parcelas',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'data_inicio_bolsa', array(
            'label'      => 'data_inicio_bolsa',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'data_fim_bolsa', array(
            'label'      => 'data_fim_bolsa',
            'required'   => true,
        ));

        $this->addElement('select', 'orcamento_id', array(
            'label'      => 'orcamento_id',
            'multiOptions' => Application_Model_Orcamento::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'usuario_id', array(
            'label'      => 'usuario_id',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'pre_empenho_id', array(
            'label'      => 'pre_empenho_id',
            'multiOptions' => Application_Model_PreEmpenho::getOptions(),
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));


    }
}
