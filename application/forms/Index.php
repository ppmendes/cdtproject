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
class Application_Form_Index extends Zend_Form
{

    public function init()
    {
        // Setar metodo
        $this->setMethod('post');

        //input type text
        $this->addElement('text', 'username', array(
            'label'      => 'Usuário: ',
            'required'   => true,
        ));

        //input type text
        $this->addElement('password', 'password', array(
            'label'      => 'Senha: ',
            'required'   => true,
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));


    }
}
