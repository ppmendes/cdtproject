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
            'label'      => 'Descrição: ',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'processo_administrativo', array(
            'label'      => 'Processo Administrativo: ',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'historico', array(
            'label'      => 'Histórico: ',
            'required'   => true,
        ));

        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data');
        $emtDatePicker1->setLabel('Data: ');
        $emtDatePicker1->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker1);

        $this->addElement('select', 'beneficiario_id', array(
            'label'      => 'Beneficiário: ',
            'multiOptions' => Application_Model_Beneficiario::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto: ',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true
        ));

        //input type text
        $this->addElement('text', 'valor_empenho', array(
            'label'      => 'Valor: ',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'numero_parcelas', array(
            'label'      => 'Número de Parcelas: ',
            'required'   => true,
        ));

        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_inicio_bolsa');
        $emtDatePicker2->setLabel('Data de Início da Bolsa: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker2);

        $emtDatePicker3 = new ZendX_JQuery_Form_Element_DatePicker('data_fim_bolsa');
        $emtDatePicker3->setLabel('Data do Fim da Bolsa: ');
        $emtDatePicker3->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker3);

        $this->addElement('select', 'orcamento_id', array(
            'label'      => 'Orçamento: ',
            'multiOptions' => Application_Model_Orcamento::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'usuario_id', array(
            'label'      => 'Usuário: ',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true
        ));

        $this->addElement('select', 'pre_empenho_id', array(
            'label'      => 'Pré Empenho: ',
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
