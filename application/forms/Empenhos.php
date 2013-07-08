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

    public function setProjetoId($id_projeto_controller){
        $this->id_projeto = $id_projeto_controller;
    }

   // public function init() {}

    public function startform()
    {
        $this->setIsArray('true');
        $this->setElementsBelongTo('empenhos');
        $this->setAttrib('enctype', 'multipart/form-data');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Empenhos',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));
        
        $this->addElement('select', 'orcamento_id', array(
            'label'      => 'Rubrica: ',
            'multiOptions' => Application_Model_Empenho::getOrcamentosNaoPagos($this->id_projeto),
            'required'   => true,
            'attribs'    => array('onchange' => 'saldoOrcamentoDisponibilizado(this.value)'),
        ));

        $this->addElement('multiselect', 'tarefas', array(
            'label'      => 'Tarefas:',
            'multiOptions' => Application_Model_Tarefa::getTarefasByIdProjeto($this->id_projeto),
            'required'   => false,
            'size'=>8,
            'RegisterInArrayValidator'=>false
        ));

        $this->addElement('button', 'botao_Adicionar_Tarefa', array(
            'required' => false,
            'label'     => '>>',
        ));

        $this->addElement('button', 'botao_Deletar_Tarefa', array(
            'required' => false,
            'label'     => '<<',
        ));

        $this->addDisplayGroup(array('botao_Adicionar_Tarefa','botao_Deletar_Tarefa'), 'individual');

        $individual = $this->getDisplayGroup('individual');

        $individual->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'cronograma'))
        ));

        $this->addElement('multiselect', 'tarefa_empenho', array(
            ///'label' => 'xxx',
            'required'   => false,
            'size'=>8,
            // aqui puede estar el error provar em tarefas modificando este linha
            'multiOptions' => Application_Model_TarefasDependentes::getOptions($this->id_tarefa),
            'RegisterInArrayValidator'=>false,

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

        $elemento = $this->getElement('valor_empenho');
        $elemento->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => 1000)));

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

    public function preValidation(array $data)
    {
        $dados = $_POST;
        $valor_empenho = $this->getElement('valor_empenho');
        $saldo_orcamento_disponibilizado = $dados['empenhos']['saldo_orcamento_disponibilizado'];

        $valor_empenho->removeValidator('Zend_Validate_Between2');
        $valor_empenho->addValidator(new Zend_Validate_Between2(array('min' => '0,00', 'max' => $saldo_orcamento_disponibilizado)));
    }
}
