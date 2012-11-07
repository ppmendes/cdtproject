<?php

class Application_Form__Solicitacoes_PassagensDiarias extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('solicitacoes');

        // Setar metodo
        $this->setMethod('post');

        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Passagens e Diárias',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));


        $this->addElement('hidden', 'label_projeto', array(
            'description' => 'Identificação do Projeto',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Projeto input type text
        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto:',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true
        ));

        //Coordenador do projeto input type text
        $this->addElement('select', 'coodenador_projeto', array(
            'label'      => 'Coordenador do Projeto:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true
        ));

        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true
        ));

        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true
        ));

        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
            'required'   => false
        ));

        $this->addElement('hidden', 'label_beneficiario', array(
            'description' => 'Identificação do Beneficiário',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $array_vinculo = array(
            1 => 'Servidor',
            2 => 'Colaborador Eventual',
            3 => 'Convidado',
            4 => 'Assessoramento Especial',
        );

        //progresso da tarefa select type
        $this->addElement('select', 'vinculo', array(
            'label'      => 'Vínculo Institucional:',
            'multiOptions'  => $array_vinculo,
            'required'   => true
        ));

        //Beneficiário input type text
        $this->addElement('select', 'beneficiario_id', array(
            'label'      => 'Beneficiário:',
            'multiOptions' => Application_Model_Beneficiario::getOptions(),
            'required'   => true
        ));

        $this->addElement('text', 'cargo', array(
            'label'      => 'Cargo/Profissão:',
            'required'   => true,
        ));

        $this->addElement('text', 'unidade', array(
            'label'      => 'Unidade/Departamento:',
            'required'   => true,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CPF:',
            'required'   => true,
        ));

        //RG input type text
        $this->addElement('text', 'rg_ie', array(
            'label'      => 'RG:',
            'required'   => false,
        ));

        //E-mail input type text
        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
        ));

        $this->addElement('select', 'banco_id', array(
            'label'      => 'Banco:',
            'multiOptions' => Application_Model_Banco::getOptions(),
            'required'   => true
        ));
        //Agencia input type text
        $this->addElement('text', 'agencia_banco', array(
            'label'      => 'Agência:',
            'required'   => true,
        ));

        //Conta input type text
        $this->addElement('text', 'conta_bancaria', array(
            'label'      => 'Conta:',
            'required'   => true,
        ));

        $this->addElement('hidden', 'label_motivo', array(
            'description' => 'Motivo da Viagem',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('textarea', 'motivos', array(
            'label'      => 'Objeto/Assunto a ser tratado/Evento:',
            'required'   => true
        ));

        $this->addElement('hidden', 'label_viagem', array(
            'description' => 'Dados para emissão da Passagem e Pagamento de Diárias (Efetuar reserva com menor preço)',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Projeto input type text
        $this->addElement('select', 'tipo_diarias_passagens', array(
            'label'      => 'Emissão do Bilhete da Passagem:',
            'multiOptions' => Application_Model_TipoDiariasPassagens::getOptions(),
            'required'   => true
        ));

        //Data da solicitação
        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data_saida');
        $emtDatePicker1->setLabel('Data de Ida: ');
        $emtDatePicker1->setJQueryParam('dateFormat', 'yy-mm-dd');
        $this->addElement($emtDatePicker1);

        //Data da solicitação
        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_volta');
        $emtDatePicker2->setLabel('Data de Volta: ');
        $emtDatePicker2->setJQueryParam('dateFormat', 'yy-mm-dd');
        $this->addElement($emtDatePicker2);

        $this->addElement('text', 'hora_saida', array(
            'label'      => 'Horário Desejado Ida:',
            'required'   => true,
        ));

        $this->addElement('text', 'hora_chegada', array(
            'label'      => 'Horário Desejado Volta:',
            'required'   => true,
        ));

        $this->addElement('text', 'tipo_detalhe', array(
            'label'      => 'Trecho:',
            'required'   => true,
        ));

        $this->addElement('text', 'valor_passagens', array(
            'label'      => 'Valor estimado de passagens:',
            'required'   => true,
        ));

        $this->addElement('text', 'local', array(
            'label'      => 'Local:',
            'required'   => true,
        ));

        $this->addElement('text', 'data', array(
            'label'      => 'Data:',
            'required'   => true,
        ));

        $this->addElement('text', 'valor', array(
            'label'      => 'Valor estimando de diárias:',
            'required'   => true,
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));


    }
}
