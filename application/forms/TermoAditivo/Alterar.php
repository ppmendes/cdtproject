<?php

class Application_Form_TermoAditivo_Alterar extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('termoaditivo');

        // Setar metodo
        $this->setMethod('post');

        //Nome do projeto input type text
        $this->addElement('text', 'despesadestinatario', array(
            'label'      => 'Elemento de Despesa Destinatário:',
            'required'   => true,
        ));

        //Coordenador do projeto input type text
        $this->addElement('text', 'valor', array(
            'label'      => 'Valor (R$):',
            'required'   => true
        ));

        //Gerência input type text
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
