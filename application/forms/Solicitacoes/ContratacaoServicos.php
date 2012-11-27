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
            'order'          => 1,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Projeto input type text
        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto:',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true,
            'order'          => 2,

        ));

        //Coordenador do projeto input type text
        $this->addElement('select', 'coodenador_projeto', array(
            'label'      => 'Coordenador do Projeto:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true,
            'order'          => 3,
        ));

        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
            'order'          => 4,
        ));

        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
            'order'          => 5,
        ));

        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
            'required'   => false,
            'order'          => 6
        ));

        $this->addElement('hidden', 'label_beneficiario', array(
            'description' => 'Dados do Contratado',
            'ignore' => true,
            'order'          => 7,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Beneficiário input type text
        $this->addElement('select', 'beneficiario_id', array(
            'label'      => 'Beneficiário:',
            'multiOptions' => Application_Model_Beneficiario::getOptions(),
            'required'   => true,
            'order'          => 8,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CPF:',
            'required'   => true,
            'order'          => 9,
        ));

        //RG input type text
        $this->addElement('text', 'rg_ie', array(
            'label'      => 'RG:',
            'required'   => false,
            'order'          => 10,
        ));

        //RG input type text
        $this->addElement('text', 'pis_inss', array(
            'label'      => 'PIS ou INSS:',
            'required'   => false,
            'order'          => 11,
        ));

        //RG input type text
        $this->addElement('text', 'endereco', array(
            'label'      => 'Endereço:',
            'required'   => false,
            'order'          => 12,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
            'order'          => 13,
        ));

        //celular input type text
        $this->addElement('text', 'celular', array(
            'label'      => 'Telefone:',
            'required'   => true,
            'order'          => 14,
        ));

        //E-mail input type text
        $this->addElement('text', 'email2', array(
            'label'      => 'E-mail:',
            'required'   => true,
            'order'          => 15,
        ));

        $this->addElement('hidden', 'label_banco', array(
            'description' => 'Dados Bancários',
            'ignore' => true,
            'order'          => 16,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'interna')),
            ),
        ));

        $this->addElement('select', 'banco_id', array(
            'label'      => 'Banco:',
            'order'          => 17,
            'multiOptions' => Application_Model_Banco::getOptions(),
            'required'   => true
        ));
        //Agencia input type text
        $this->addElement('text', 'agencia_banco', array(
            'label'      => 'Agência:',
            'required'   => true,
            'order'          => 18,
        ));

        //Conta input type text
        $this->addElement('text', 'conta_bancaria', array(
            'label'      => 'Conta:',
            'required'   => true,
            'order'          => 19,
        ));

        $this->addElement('hidden', 'label_plano_trabalho', array(
            'description' => 'Plano de Trabalho de Execução de Serviço (Meta/Etapa/Atividade)',
            'ignore' => true,
            'order'          => 20,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('textarea', 'objeto', array(
            'label'      => 'Objeto do Serviço:',
            'required'   => true,
            'order'          => 21,
        ));

        $this->addElement('textarea', 'objeto_justificativa', array(
            'label'      => 'Objeto do Serviço (justificativa/motivação):',
            'required'   => true,
            'order'          => 22,
        ));

        $this->addElement('hidden', 'label_cronograma', array(
            'description' => 'Cronograma de Atividades(descrição das ATIVIDADES a serem executadas (metodologia) e os PRODUTOS a serem entregues )',
            'ignore' => true,
            'order'          => 23,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'interna', 'style'=>'font-size: 13px;')),
            ),
        ));

        $this->addElement('text', 'descricao', array(
            'label'      => 'Descricao:',
            'required'   => true,
            'order'          => 24,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'produto', array(
            'label'      => 'Produto:',
            'required'   => true,
            'order'          => 25,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'qtde', array(
            'label'      => 'Qtde:',
            'required'   => true,
            'order'          => 26,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'cronograma_inicio', array(
            'label'      => 'Início do Cronograma:',
            'required'   => true,
            'order'          => 27,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'cronograma_termino', array(
            'label'      => 'Fim do Cronograma:',
            'required'   => true,
            'order'          => 28,
            'class'         => 'campos'
        ));

        $this->addDisplayGroup(array('descricao','produto','qtde', 'cronograma_inicio', 'cronograma_termino'), 'individual');

        $individual = $this->getDisplayGroup('individual');

        $individual->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'cronograma'))
        ));

        $individual->setOrder(29);

        $this->addElement('button', 'add_item_mais', array(
            'label'      => 'Mais',
            'ignore'   => true,
            'id'         => 'botao_mais',
            'order'          => 100,
            'attribs' => array('onClick' => 'adicionaCampo()'),

        ));

        $this->addElement('button', 'add_item_menos', array(
            'label'      => 'Menos',
            'ignore'   => true,
            'order'          => 101,
            'id'         => 'botao_menos',
            'attribs' => array('onClick' => 'removeCampo()'),


        ));

        $this->addElement('textarea', 'resultados_esperados', array(
            'label'      => 'Resultados esperados:',
            'required'   => true,
            'order'          => 102
        ));

//        $this->addElement('text', 'valor_total', array(
//            'label'      => 'Valor Total do Serviço:',
//            'required'   => true,
//            'class'      => 'pagamento_campos',
//        ));
//
//        $this->addElement('text', 'execucao_inicio', array(
//            'label'      => 'Início:',
//            'required'   => true,
//            'class'      => 'pagamento_campos',
//        ));
//
//        $this->addElement('text', 'execucao_termino', array(
//            'label'      => 'Término:',
//            'required'   => true,
//            'class'      => 'pagamento_campos',
//        ));
//
//        $this->addElement('text', 'qtd_parcelas', array(
//            'label'      => 'Qtde de Parcelas:',
//            'required'   => true,
//            'class'      => 'pagamento_campos',
//        ));
//
//        $this->addElement('text', 'valor_parcelas', array(
//            'label'      => 'Valor das Parcelas:',
//            'required'   => true,
//            'class'      => 'pagamento_campos',
//        ));
//
//        $this->addElement('text', 'data_pagamento', array(
//            'label'      => 'Data(s) Pagamento:',
//            'required'   => true,
//            'class'      => 'pagamento_campos',
//        ));  108
//
//        $this->addDisplayGroup(array('valor_total','execucao_inicio','execucao_termino', 'qtd_parcelas', 'valor_parcelas', 'data_pagamento'), 'individual2');
//
//        $individual2 = $this->getDisplayGroup('individual2');
//
//        $individual2->setDecorators(array(
//            'FormElements',
//            array('HtmlTag',array('tag'=>'div','id'=>'pagamento'))
//
//        ));
//
//        $this->addElement('button', 'add_item_mais_2', array(
//            'label'      => 'Mais',
//            'required'   => true,
//            'id'         => 'botao_mais',
//            'attribs' => array('onClick' => 'adicionaCampo2()'),
//
//        ));          109
//
//        $this->addElement('button', 'add_item_menos_2', array(
//            'label'      => 'Menos',
//            'required'   => true,
//            'id'         => 'botao_menos',
//            'attribs' => array('onClick' => 'removeCampo2()'),
//
//
//        ));             110

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'order'          => 200,
            'label'    => 'Enviar',
        ));

        //set hidden
        $this->addElement('hidden', 'hidden_teste', array(
            'value'      => '',
            'order'          => 201,
        ));

        //set hidden
        $this->addElement('hidden', 'hidden2_teste', array(
            'value'      => '' ,
            'order'          => 202,
        ));


    }

    public function preValidation(array $data) {

//        // array_filter callback
//        function findFields($field) {
//            // return field names that include 'newName'
//            if (strpos($field, 'newName') !== false) {
//                return $field;
//            }
//        }
//
//        // Search $data for dynamically added fields using findFields callback
//        $newFields = array_filter(array_keys($data), 'findFields');
//
//        foreach ($newFields as $fieldName) {
//            // strip the id number off of the field name and use it to set new order
//            $order = ltrim($fieldName, 'newName') + 2;
//            $this->addNewField($fieldName, $data[$fieldName], $order);
//        }
//    }
        echo "<script>recuperaNum()</script>";
        $dados = $_POST;
        $num = $dados['solicitacoes']['hidden_teste'];
        $order = 31;
        //$name = $dados['solicitacoes']['descricao_2'];
        for ( $i = 2; $i<=$num ; $i++) {
        $name1 = "descricao_". $i;
        $name2 = "produto_". $i;
        $name3 = "qtde_". $i;
        $name4 = "cronograma_inicio_". $i;
        $name5 = "cronograma_termino_". $i;
        $this->addNewField($name1, $dados['solicitacoes'][$name1], $name2 , $dados['solicitacoes'][$name2], $name3,
            $dados['solicitacoes'][$name3], $name4, $dados['solicitacoes'][$name4], $name5, $dados['solicitacoes'][$name4], $order);
        $order = $order + 5;
        }
    }

    public function addNewField($name1, $value1, $name2, $value2, $name3, $value3, $name4, $value4, $name5, $value5, $order) {

        $this->addElement('text', $name1, array(
            'required'       => true,
            'label'          => 'Descrição:',
            'value'          => $value1,
            'order'          => $order
        ));

        $order++;

        $this->addElement('text', $name2, array(
            'required'       => true,
            'label'          => 'Produto:',
            'value'          => $value2,
            'order'          => $order
        ));

        $order++;

        $this->addElement('text', $name3, array(
            'required'       => true,
            'label'          => 'Qtde:',
            'value'          => $value3,
            'order'          => $order
        ));

        $order++;

        $this->addElement('text', $name4, array(
            'required'       => true,
            'label'          => 'Início do Cronograma:',
            'value'          => $value4,
            'order'          => $order
        ));

        $order++;

        $this->addElement('text', $name5, array(
            'required'       => true,
            'label'          => 'Fim do Cronograma',
            'value'          => $value5,
            'order'          => $order
        ));


        $individual = $this->getDisplayGroup('individual');

       $individual->addElements(array ($this->getElement($name1), $this->getElement($name2), $this->getElement($name3),
           $this->getElement($name4), $this->getElement($name5)));

        echo "<script>incNum()</script>";
    }
}
?>

    <script>
    var num = 2;
    var margem = 0;
    function adicionaCampo(){
        //var x = "' + margem * (num-1) + 'px'>
        $('#cronograma').append("<dt id='solicitacoes-descricao-label' style='float:left; margin-left:'" + margem*(num-1) + "px><label for='solicitacoes-descricao_2'" +
                "class='required'>Descricao:</label></dt>");
        $('#cronograma').append("<dd id='solicitacoes-descricao-element'><input type='text' name='solicitacoes[descricao_"+
                num + "]' id='solicitacoes-descricao' value='' class='campos'></dd>");
        $('#cronograma').append('<dt id="solicitacoes-produto-label"><label for="solicitacoes-produto_2" class="required">' +
                'Produto:</label></dt>');
        $('#cronograma').append("<dd id='solicitacoes-produto-element'><input type='text' name='solicitacoes[produto_"+ num +
                "]' id='solicitacoes-produto' value='' class='campos'></dd>");
        $('#cronograma').append('<dt id="solicitacoes-qtde-label"><label for="solicitacoes-qtde_2" class="required">' +
                'Qtde:</label></dt>');
        $('#cronograma').append("<dd id='solicitacoes-qtde-element'><input type='text' name='solicitacoes[qtde_"+ num + "]' " +
                "id='solicitacoes-qtde' value='' class='campos'></dd>");
        $('#cronograma').append('<dt id="solicitacoes-cronograma_inicio-label"><label for="solicitacoes-cronograma_inicio_2" ' +
                'class="required">Início do Cronograma:</label></dt>');
        $('#cronograma').append("<dd id='solicitacoes-cronograma_inicio-element'><input type='text' " +
                "name='solicitacoes[cronograma_inicio_"+ num + "]' id='solicitacoes-cronograma_inicio' value='' class='campos'></dd>");
        $('#cronograma').append('<dt id="solicitacoes-cronograma_termino-label"><label for="solicitacoes-cronograma_termino_2" ' +
                'class="required">Fim do Cronograma:</label></dt>');
        $('#cronograma').append("<dd id='solicitacoes-cronograma_termino-element'><input type='text' " +
                "name='solicitacoes[cronograma_termino_"+ num + "]' id='solicitacoes-cronograma_termino' value='' class='campos'></dd>");
        $('#solicitacoes-hidden_teste').attr('value', num);

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
            $('#solicitacoes-hidden_teste').attr('value', num);

        }
    }

    function recuperaNum(){
        num = 2;
        $('#solicitacoes-hidden_teste').attr('value', num);
    }

    function incNum(){
        num = num + 1;
        $('#solicitacoes-hidden_teste').attr('value', num);
    }

    function getNum(){
        $('#solicitacoes-hidden_teste').attr('value', num);
        return num;

    }
</script>

<script>
    var num2 = 2;
    var margem = 0;
    function adicionaCampo2(){
        //var x = "' + margem * (num-1) + 'px'>
        $('#pagamento').append("<dt id='solicitacoes-valor_total-label' style='float:left; margin-left:'" + margem*(num-1) + "px><label for='solicitacoes-valor_total'" +
                "class='required'>Valor Total do Serviço:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-valor_total-element'><input type='text' name='solicitacoes[valor_total_" + num2 + "]' " +
                "id='solicitacoes-valor_total' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append('<dt id="solicitacoes-execucao_inicio-label"><label for="solicitacoes-execucao_inicio" class="required">' +
                'Início:</label></dt>');
        $('#pagamento').append("<dd id='solicitacoes-execucao_inicio-element'><input type='text' name='solicitacoes[execucao_inicio_" + num2 + "]' " +
                "id='solicitacoes-execucao_inicio' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append('<dt id="solicitacoes-execucao_termino-label"><label for="solicitacoes-execucao_termino" class="required">' +
                'Término:</label></dt>');
        $('#pagamento').append("<dd id='solicitacoes-execucao_termino-element'><input type='text' name='solicitacoes[execucao_termino_"+ num2 + "]' " +
                "id='solicitacoes-execucao_termino' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append('<dt id="solicitacoes-qtd_parcelas-label"><label for="solicitacoes-qtd_parcelas" ' +
                'class="required">Qtde de Parcelas:</label></dt>');
        $('#pagamento').append("<dd id='solicitacoes-qtd_parcelas-element'><input type='text' " +
                "name='solicitacoes[qtd_parcelas_" + num2 + "]' id='solicitacoes-qtd_parcelas' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append('<dt id="solicitacoes-valor_parcelas-label"><label for="solicitacoes-valor_parcelas" ' +
                'class="required">Valor das Parcelas:</label></dt>');
        $('#pagamento').append("<dd id='solicitacoes-valor_parcelas-element'><input type='text' " +
                "name='solicitacoes[valor_parcelas_"+ num2 + "]' id='solicitacoes-valor_parcelas' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append('<dt id="solicitacoes-data_pagamento-label"><label for="solicitacoes-data_pagamento" ' +
                'class="required">Data(s) Pagamento:</label></dt>');
        $('#pagamento').append("<dd id='solicitacoes-data_pagamento-element'><input type='text' " +
                "name='solicitacoes[data_pagamento_"+ num2 + "]' id='solicitacoes-data_pagamento' value='' class='pagamento_campos'></dd>");

        num2++;
        $('#solicitacoes-hidden2_teste').attr('value', num2);

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
            $('#solicitacoes-hidden2_teste').attr('value', num2);

        }
    }

    function incNum2(){
        return num2++;
    }
</script>

