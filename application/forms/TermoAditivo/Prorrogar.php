<?php

class Application_Form_TermoAditivo_Prorrogar extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('termo_aditivo');

        //pegar id do projeto
        $id_projeto  = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'projeto_id', null );
        //$id_projeto = $this->_getParam('projeto_id');
        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Prorrogação de Vigência de Contrato',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $data_termino = Application_Model_Projeto::getDataModificacao($id_projeto);
        $this->addElement('text', 'data', array(
            'label'      => 'Data Anterior:',
            'value'      => $data_termino['0']['data_final'],
            'disabled'         => true,
            'required'   => false,
        ));
        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_fim_nova');
        $emtDatePicker2->setLabel('Nova Data: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker2);

        //Coordenador do projeto input type text
        $this->addElement('textarea', 'termo_aditivo_descricao', array(
            'label'      => 'Motivo/Descrição:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

        //set hidden
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => $id_projeto
        ));

        $usuario_logado = Zend_Auth::getInstance()->getStorage()->read();

        //set hidden
        $this->addElement('hidden', 'usuario_id', array(
            'value'      => $usuario_logado->usuario_id,
        ));

        //set hidden
        $this->addElement('hidden', 'tipo_termo_aditivo_id', array(
            'value'      => '1'
        ));

        //set hidden
        $this->addElement('hidden', 'data_fim_atual', array(
            'value'      => $data_termino['0']['data_final']
        ));



    }
}
