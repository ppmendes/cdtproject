<?php

class Application_Form_TermoAditivo_Prorrogar extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('termoaditivo');

        // Setar metodo
        $this->setMethod('post');

        //Nome do projeto input type text
        $this->addElement('text', 'data_final', array(
            'label'      => 'Data de Término:',
            'required'   => true,
        ));

        //Apelido do projeto input type text
        $this->addElement('text', 'nova_data', array(
            'label'      => 'Nova Data:',
            'required'   => true
        ));

        //Coordenador do projeto input type text
        $this->addElement('textarea', 'descricao', array(
            'label'      => 'Motivo/Descrição:',
            'required'   => true
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));


    }
}
