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

        // Setar metodo
        $this->setMethod('post');

        $data_termino = Application_Model_Projeto::getDataModificacao($id_projeto);
        $this->addElement('text', 'data', array(
            'label'      => 'Data Anterior:',
            'value'      => $data_termino['0']['data_final'],
            'disabled'         => true,
            'required'   => false,
        ));
        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('nova_data');
        $emtDatePicker2->setLabel('Nova Data: ');
        $emtDatePicker2->setJQueryParam('dateFormat', 'yy-mm-dd');
        $this->addElement($emtDatePicker2);

        //Coordenador do projeto input type text
        $this->addElement('textarea', 'descricao_justificativa', array(
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

        //set hidden
        $this->addElement('hidden', 'usuario_id', array(
            'value'      => '1'
        ));

        //set hidden
        $this->addElement('hidden', 'tipo_termo_aditivo_id', array(
            'value'      => '1'
        ));

        //set hidden
        $this->addElement('hidden', 'data_anterior', array(
            'value'      => $data_termino['0']['data_final']
        ));



    }
}
