<?php

class Application_Form__Solicitacoes_ContratacaoServicos extends Zend_Form
{

    public function init()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('solicitacoes');

        // Setar metodo
        $this->setMethod('post');

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
            'description' => 'Dados do Contratado',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Beneficiário input type text
        $this->addElement('select', 'beneficiario_id', array(
            'label'      => 'Beneficiário:',
            'multiOptions' => Application_Model_Beneficiario::getOptions(),
            'required'   => true
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

        //RG input type text
        $this->addElement('text', 'pis_inss', array(
            'label'      => 'PIS ou INSS:',
            'required'   => false,
        ));

        //RG input type text
        $this->addElement('text', 'endereco', array(
            'label'      => 'Endereço:',
            'required'   => false,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
        ));

        //celular input type text
        $this->addElement('text', 'celular', array(
            'label'      => 'Telefone:',
            'required'   => true,
        ));

        //E-mail input type text
        $this->addElement('text', 'email2', array(
            'label'      => 'E-mail:',
            'required'   => true,
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

        $this->addElement('hidden', 'label_plano_trabalho', array(
            'description' => 'Plano de Trabalho de Execução de Serviço (Meta/Etapa/Atividade)',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('textarea', 'objeto', array(
            'label'      => 'Objeto do Serviço:',
            'required'   => true,
        ));

        $this->addElement('textarea', 'objeto_justificativa', array(
            'label'      => 'Objeto do Serviço (justificativa/motivação):',
            'required'   => true,
        ));

        $this->addElement('hidden', 'label_cronograma', array(
            'description' => 'Cronograma de Atividades(descrição das ATIVIDADES a serem executadas (metodologia) e os PRODUTOS a serem entregues )',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'interna', 'style'=>'font-size: 13px;')),
            ),
        ));

        $this->addElement('text', 'descricao', array(
            'label'      => 'Descricao:',
            'required'   => true,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'produto', array(
            'label'      => 'Produto:',
            'required'   => true,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'qtde', array(
            'label'      => 'Qtde:',
            'required'   => true,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'cronograma_inicio', array(
            'label'      => 'Início do Cronograma:',
            'required'   => true,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'cronograma_termino', array(
            'label'      => 'Fim do Cronograma:',
            'required'   => true,
            'class'         => 'campos'
        ));

        $this->addDisplayGroup(array('descricao','produto','qtde', 'cronograma_inicio', 'cronograma_termino'), 'individual');

        $individual = $this->getDisplayGroup('individual');

        $individual->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'cronograma'))

        ));

        $this->addElement('button', 'add_item_mais', array(
            'label'      => 'Mais',
            'required'   => true,
            'id'         => 'botao_mais',
            'attribs' => array('onClick' => 'adicionaCampo()'),

        ));

        $this->addElement('button', 'add_item_menos', array(
            'label'      => 'Menos',
            'required'   => true,
            'id'         => 'botao_menos',
            'attribs' => array('onClick' => 'removeCampo()'),


        ));

        $this->addElement('textarea', 'resultados_esperados', array(
            'label'      => 'Resultados esperados:',
            'required'   => true
        ));

        $this->addElement('text', 'valor_total', array(
            'label'      => 'Valor Total do Serviço:',
            'required'   => true,
            'class'      => 'pagamento_campos',
        ));

        $this->addElement('text', 'execucao_inicio', array(
            'label'      => 'Início:',
            'required'   => true,
            'class'      => 'pagamento_campos',
        ));

        $this->addElement('text', 'execucao_termino', array(
            'label'      => 'Término:',
            'required'   => true,
            'class'      => 'pagamento_campos',
        ));

        $this->addElement('text', 'qtd_parcelas', array(
            'label'      => 'Qtde de Parcelas:',
            'required'   => true,
            'class'      => 'pagamento_campos',
        ));

        $this->addElement('text', 'valor_parcelas', array(
            'label'      => 'Valor das Parcelas:',
            'required'   => true,
            'class'      => 'pagamento_campos',
        ));

        $this->addElement('text', 'data_pagamento', array(
            'label'      => 'Data(s) Pagamento:',
            'required'   => true,
            'class'      => 'pagamento_campos',
        ));

        $this->addDisplayGroup(array('valor_total','execucao_inicio','execucao_termino', 'qtd_parcelas', 'valor_parcelas', 'data_pagamento'), 'individual2');

        $individual2 = $this->getDisplayGroup('individual2');

        $individual2->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'pagamento'))

        ));

        $this->addElement('button', 'add_item_mais_2', array(
            'label'      => 'Mais',
            'required'   => true,
            'id'         => 'botao_mais',
            'attribs' => array('onClick' => 'adicionaCampo2()'),

        ));

        $this->addElement('button', 'add_item_menos_2', array(
            'label'      => 'Menos',
            'required'   => true,
            'id'         => 'botao_menos',
            'attribs' => array('onClick' => 'removeCampo2()'),


        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));


    }
}
?>

    <script>
    var num = 2;
    var margem = 0;
    function adicionaCampo(){
        //var x = "' + margem * (num-1) + 'px'>
        $('#cronograma').append("<dt id='solicitacoes-descricao-label' style='float:left; margin-left:'" + margem*(num-1) + "px><label for='solicitacoes-descricao'" +
                "class='required'>Descricao:</label></dt>");
        $('#cronograma').append('<dd id="solicitacoes-descricao-element"><input type="text" name="solicitacoes[descricao]" ' +
                'id="solicitacoes-descricao" value="" class="campos"></dd>');
        $('#cronograma').append('<dt id="solicitacoes-produto-label"><label for="solicitacoes-produto" class="required">' +
                'Produto:</label></dt>');
        $('#cronograma').append('<dd id="solicitacoes-produto-element"><input type="text" name="solicitacoes[produto]" ' +
                'id="solicitacoes-produto" value="" class="campos"></dd>');
        $('#cronograma').append('<dt id="solicitacoes-qtde-label"><label for="solicitacoes-qtde" class="required">' +
                'Qtde:</label></dt>');
        $('#cronograma').append('<dd id="solicitacoes-qtde-element"><input type="text" name="solicitacoes[qtde]" ' +
                'id="solicitacoes-qtde" value="" class="campos"></dd>');
        $('#cronograma').append('<dt id="solicitacoes-cronograma_inicio-label"><label for="solicitacoes-cronograma_inicio" ' +
                'class="required">Início do Cronograma:</label></dt>');
        $('#cronograma').append('<dd id="solicitacoes-cronograma_inicio-element"><input type="text" ' +
                'name="solicitacoes[cronograma_inicio]" id="solicitacoes-cronograma_inicio" value="" class="campos"></dd>');
        $('#cronograma').append('<dt id="solicitacoes-cronograma_termino-label"><label for="solicitacoes-cronograma_termino" ' +
                'class="required">Fim do Cronograma:</label></dt>');
        $('#cronograma').append('<dd id="solicitacoes-cronograma_termino-element"><input type="text" ' +
                'name="solicitacoes[cronograma_termino]" id="solicitacoes-cronograma_termino" value="" class="campos"></dd>');
        num++;
    }

    function removeCampo(){
        if (num > 2) {
            $('#cronograma dd:last-child').remove();
            $('#cronograma dt:last-child').remove();
            $('#cronograma dd:last-child').remove();
            $('#cronograma dt:last-child').remove();
            $('#cronograma dd:last-child').remove();
            $('#cronograma dt:last-child').remove();
            $('#cronograma dd:last-child').remove();
            $('#cronograma dt:last-child').remove();
            $('#cronograma dd:last-child').remove();
            $('#cronograma dt:last-child').remove();

            num--;
        }
    }
</script>

<script>
    var num2 = 2;
    var margem = 0;
    function adicionaCampo2(){
        //var x = "' + margem * (num-1) + 'px'>
        $('#pagamento').append("<dt id='solicitacoes-valor_total-label' style='float:left; margin-left:'" + margem*(num-1) + "px><label for='solicitacoes-valor_total'" +
                "class='required'>Valor Total do Serviço:</label></dt>");
        $('#pagamento').append('<dd id="solicitacoes-valor_total-element"><input type="text" name="solicitacoes[valor_total]" ' +
                'id="solicitacoes-valor_total" value="" class="pagamento_campos"></dd>');
        $('#pagamento').append('<dt id="solicitacoes-execucao_inicio-label"><label for="solicitacoes-execucao_inicio" class="required">' +
                'Início:</label></dt>');
        $('#pagamento').append('<dd id="solicitacoes-execucao_inicio-element"><input type="text" name="solicitacoes[execucao_inicio]" ' +
                'id="solicitacoes-execucao_inicio" value="" class="pagamento_campos"></dd>');
        $('#pagamento').append('<dt id="solicitacoes-execucao_termino-label"><label for="solicitacoes-execucao_termino" class="required">' +
                'Término:</label></dt>');
        $('#pagamento').append('<dd id="solicitacoes-execucao_termino-element"><input type="text" name="solicitacoes[execucao_termino]" ' +
                'id="solicitacoes-execucao_termino" value="" class="pagamento_campos"></dd>');
        $('#pagamento').append('<dt id="solicitacoes-qtd_parcelas-label"><label for="solicitacoes-qtd_parcelas" ' +
                'class="required">Qtde de Parcelas:</label></dt>');
        $('#pagamento').append('<dd id="solicitacoes-qtd_parcelas-element"><input type="text" ' +
                'name="solicitacoes[qtd_parcelas]" id="solicitacoes-qtd_parcelas" value="" class="pagamento_campos"></dd>');
        $('#pagamento').append('<dt id="solicitacoes-valor_parcelas-label"><label for="solicitacoes-valor_parcelas" ' +
                'class="required">Valor das Parcelas:</label></dt>');
        $('#pagamento').append('<dd id="solicitacoes-valor_parcelas-element"><input type="text" ' +
                'name="solicitacoes[valor_parcelas]" id="solicitacoes-valor_parcelas" value="" class="pagamento_campos"></dd>');
        $('#pagamento').append('<dt id="solicitacoes-data_pagamento-label"><label for="solicitacoes-data_pagamento" ' +
                'class="required">Data(s) Pagamento:</label></dt>');
        $('#pagamento').append('<dd id="solicitacoes-data_pagamento-element"><input type="text" ' +
                'name="solicitacoes[data_pagamento]" id="solicitacoes-data_pagamento" value="" class="pagamento_campos"></dd>');

        num2++;
    }

    function removeCampo2(){
        if (num2 > 2) {
            $('#pagamento dd:last-child').remove();
            $('#pagamento dt:last-child').remove();
            $('#pagamento dd:last-child').remove();
            $('#pagamento dt:last-child').remove();
            $('#pagamento dd:last-child').remove();
            $('#pagamento dt:last-child').remove();
            $('#pagamento dd:last-child').remove();
            $('#pagamento dt:last-child').remove();
            $('#pagamento dd:last-child').remove();
            $('#pagamento dt:last-child').remove();
            $('#pagamento dd:last-child').remove();
            $('#pagamento dt:last-child').remove();

            num2--;
        }
    }
</script>