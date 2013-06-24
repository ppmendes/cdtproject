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
class Application_Form_Beneficiarios_MapeamentodeBeneficiarios extends Zend_Form
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
        $this->setElementsBelongTo('projeto_beneficiario');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Mapeamento de Beneficiários ao projeto',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $nomeProjeto = Application_Model_Projeto::getNome($this->id_projeto);
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto: ',
            'value'      => $nomeProjeto['0']['nome'],
            'required'   => true,
            'readonly'   => true,
            'ignore'     => true
        ));


        $this->addElement('text', 'beneficiario', array(
            'label'      => '*Beneficiário: ',
            'ignore'     => true,
            'required'   => true,
        ));


        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

        $this->addElement('hidden', 'beneficiario_id', array(
            'value'      => '',
        ));

        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $this->id_projeto,
        ));

    }
}
