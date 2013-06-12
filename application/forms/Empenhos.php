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

    private $id_projeto;

    public function setProjetoId($id_projeto){
        $this->id_projeto = $id_projeto;
    }


    public function init() {}

    public function startform()
    {
        $this->setIsArray('true');
        //$this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('empenhos');

        // Setar metodo
        $this->setMethod('post');
        
        $this->addElement('select', 'orcamento_id', array(
            'label'      => 'Rubrica: ',
            'multiOptions' => Application_Model_Empenho::getOrcamentosNaoPagos($this->id_projeto),
            'required'   => true,
            'attribs'    => array('onchange' => 'saldoOrcamentoDisponibilizado(this.value)'),
        ));
        
        //input type text
        $this->addElement('text', 'descricao_historico', array(
            'label'      => '*Descrição: ',
            'required'   => true,
        ));

        //input type text
        $this->addElement('text', 'processo_administrativo', array(
            'label'      => '*Processo Administrativo: ',
            'class'      => 'mask_processoadministrativo',
            'required'   => true,
        ));

        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data');
        $emtDatePicker1->setLabel('*Data: ');
        $emtDatePicker1->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker1);
        
        $this->addElement('text', 'beneficiario', array(
            'label'      => '*Beneficiário: ',
            'ignore'     => true,
            'required'   => true,
        ));
        
        $nomeProjeto = Application_Model_Projeto::getNome($this->id_projeto);
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto: ',
             'value'      => $nomeProjeto['0']['nome'],
            'required'   => true,
            'readonly'   => true,
            'ignore'     => true
        ));

        //input type text
        $this->addElement('text', 'valor_empenho', array(
            'label'      => '*Valor: ',
            'required'   => true,
            'attribs'    => array('maxLength' => 13),
            'onkeyup' => "this.value=mask(this.value, '###.###.###,##')",
        ));

        //$elemento = $this->getElement('valor_empenho');
        //$elemento->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => 20000)));

        //input type text
        $this->addElement('text', 'numero_parcelas', array(
            'label'      => 'Número de Parcelas: ',
            'class'      => 'positive-integer',
            
        ));

        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_inicio');
        $emtDatePicker2->setLabel('Data de Início da Bolsa: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker2);

        $emtDatePicker3 = new ZendX_JQuery_Form_Element_DatePicker('data_fim');
        $emtDatePicker3->setLabel('Data do Fim da Bolsa: ');
        $emtDatePicker3->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker3);

        $usuario_logado = Zend_Auth::getInstance()->getStorage()->read();
        
        $this->addElement('text', 'usuario', array(
            'label'      => 'Usuário: ',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'readonly'   => true,
            'ignore'   => true,
            
            'value'     => $usuario_logado->nome
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));
        
        

        $this->addElement('hidden', 'beneficiario_id', array(
            'value'      => '',
        ));
        
        $this->addElement('hidden', 'usuario_id', array(
            'value'      => $usuario_logado->usuario_id,
        ));
        
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $this->id_projeto,
        ));

        $this->addElement('hidden', 'saldo_orcamento_disponibilizado', array(
            'value'      => '',
            'ignore'     => true,
        ));

    }
}
