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
        $emt = new ZendX_JQuery_Form_Element_AutoComplete('ac');
        $emt->setLabel('Beneficiario:');
        $emt->setRequired(true);
        $emt->setJQueryParam('data', Application_Model_Beneficiario::getOptions())
            ->setJQueryParams(array("select" => new Zend_Json_Expr(
            'function(event,ui) { $("#solicitacoes-beneficiario_id").val(ui.item.id); preencher();}')
        ));
        $this->addElement($emt);

        $this->addElement('text', 'cargo', array(
            'label'      => 'Cargo/Profissão:',
            'required'   => true,
        ));

        $this->addElement('text', 'unidade', array(
            'label'      => 'Unidade/Departamento:',
            'required'   => true,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone_contratado', array(
            'label'      => 'Telefone:',
            'required'   => true,
            'readonly'   => true,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CPF:',
            'required'   => true,
            'readonly'   => true,
        ));

        //RG input type text
        $this->addElement('text', 'rg_ie', array(
            'label'      => 'RG:',
            'required'   => false,
            'readonly'   => true,
        ));

        //E-mail input type text
        $this->addElement('text', 'email_contratado', array(
            'label'      => 'E-mail:',
            'required'   => true,
            'readonly'   => true,
        ));

        $this->addElement('hidden', 'label_banco', array(
            'description' => 'Dados Bancários',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'interna')),
            ),
        ));

        $this->addElement('select', 'banco_id', array(
            'label'      => 'Banco:',
            'multiOptions' => Application_Model_Banco::getOptions(),
            'required'   => true,
            'readonly'   => true,
        ));
        //Agencia input type text
        $this->addElement('text', 'agencia_banco', array(
            'label'      => 'Agência:',
            'required'   => true,
            'readonly'   => true,
        ));

        //Conta input type text
        $this->addElement('text', 'conta_bancaria', array(
            'label'      => 'Conta:',
            'required'   => true,
            'readonly'   => true,
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

        $this->addElement('hidden', 'label_passagem', array(
            'description' => 'Passagem',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'interna')),
            ),
        ));

        $this->addElement('select', 'tipo_diarias_passagens', array(
            'label'      => 'Emissão do Bilhete da Passagem:',
            'multiOptions' => Application_Model_TipoDiariasPassagens::getOptions(),
            'required'   => true
        ));

        //Data da solicitação
        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('data_saida');
        $emtDatePicker1->setLabel('Data de Ida: ');
        $emtDatePicker1->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker1);

        //Data da solicitação
        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('data_volta');
        $emtDatePicker2->setLabel('Data de Volta: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
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

        $this->addElement('hidden', 'label_diaria', array(
            'description' => 'Diárias',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'interna')),
            ),
        ));

        $this->addElement('text', 'local', array(
            'label'      => 'Local:',
            'required'   => true,
        ));

        $emtDatePicker3 = new ZendX_JQuery_Form_Element_DatePicker('data');
        $emtDatePicker3->setLabel('Data: ');
        $emtDatePicker3->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker3);

        $this->addElement('text', 'valor', array(
            'label'      => 'Valor estimado de diárias:',
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


    }
}

?>

<script>

    function preencher()
    {
        var valor = 'id=' + $('#solicitacoes-beneficiario_id').val();
        $.ajax({
            url: '/solicitacoes/preenchebeneficiario/',
            dataType:'json',
            data: valor,
            success: function(data){
                $('#solicitacoes-cpf_cnpj').val(data.cpf_cnpj);
                $('#solicitacoes-rg_ie').val(data.rg_ie);
                $('#solicitacoes-telefone_contratado').val(data.telefone);
                $('#solicitacoes-email_contratado').val(data.email);
                $('#solicitacoes-banco_id').val(data.banco_id);
                $('#solicitacoes-agencia_banco').val(data.agencia_banco);
                $('#solicitacoes-conta_bancaria').val(data.conta_bancaria);

            }
        })
    }

</script>
