<?php

class Application_Form_Solicitacoes_ContratacaoServicos extends Zend_Form
{

    public $decoratorMaior = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag'=> 'dd', 'class' => 'maior')),
        array('Label', array('tag'=> 'dt', 'class' => 'maior_label')),
        array()
    );

    public $decoratorMenor = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag'=> 'dd', 'class' => 'menor')),
        array('Label', array('tag'=> 'dt', 'class' => 'menor_label')),
        array()
    );

    public function startform()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('solicitacoes');

        // Setar metodo
        $this->setMethod('post');

        //Projeto input type text
        $this->addElement('text', 'solicitacao_nome', array(
            'label'      => 'Nome da Solicitação:',
            'required'   => true,

        ));

        //Data da solicitação
        $this->addElement('text', 'data_solicitacao_view', array(
            'label'      => 'Data da Solicitação:',
            'value'      => date('Y-m-d', time()),
            'disabled'   => true,
            'required'   => false,
            'order'          => 1,
            'ignore'     => true,
        ));

        $this->addElement('hidden', 'label_projeto', array(
            'description' => 'Identificação do Projeto',
            'ignore' => true,
            'order'          => 2,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Projeto input type text
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto:',
            'required'   => true,
            'order'          => 3,
            'ignore'     => true,
        ));

        //Coordenador do projeto input type text
        $this->addElement('text', 'coordenador_projeto', array(
            'label'      => 'Coordenador do Projeto:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 4,
        ));

        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 5,
            'ignore'         => true,
        ));

        $this->addElement('text', 'telefone_coordenador', array(
            'label'      => 'Telefone:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 6,
            'ignore'         => true,
        ));

        $this->addElement('text', 'celular_coordenador', array(
            'label'      => 'Celular:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 7,
            'ignore'         => true,
        ));


        $this->addElement('hidden', 'label_beneficiario', array(
            'description' => 'Dados do Contratado',
            'ignore' => true,
            'order'          => 8,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));


        $this->addElement('text', 'beneficiario', array(
            'label'      => 'Beneficiário:',
            'required'   => true,
            'order'      => 9,
            'ignore'     => true,
        ));

        //CPF input type text
        $this->addElement('text', 'cpf_cnpj', array(
            'label'      => 'CPF:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 10,
            'ignore'         => true,
        ));

        //RG input type text
        $this->addElement('text', 'rg_ie', array(
            'label'      => 'RG:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 11,
            'ignore'         => true,
        ));

        //RG input type text
        $this->addElement('text', 'pis_inss', array(
            'label'      => 'PIS ou INSS:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 12,
            'ignore'         => true,
        ));

        //RG input type text
        $this->addElement('text', 'endereco_contratado', array(
            'label'      => 'Endereço:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 13,
            'ignore'         => true,
        ));

        //Telefone input type text
        $this->addElement('text', 'telefone_contratado', array(
            'label'      => 'Telefone:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 14,
            'ignore'         => true,
        ));

        //E-mail input type text
        $this->addElement('text', 'email_contratado', array(
            'label'      => 'E-mail:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 15,
            'ignore'         => true,
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
            'required'   => false,
            'readonly'   => true,
            'ignore'         => true,
        ));
        //Agencia input type text
        $this->addElement('text', 'agencia_banco', array(
            'label'      => 'Agência:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 18,
            'ignore'         => true,
        ));

        //Conta input type text
        $this->addElement('text', 'conta_bancaria', array(
            'label'      => 'Conta:',
            'required'   => false,
            'readonly'   => true,
            'order'          => 19,
            'ignore'         => true,
        ));

        $this->addElement('hidden', 'label_plano_trabalho', array(
            'description' => 'Plano de Trabalho de Execução de Serviço (Meta/Etapa/Atividade)',
            'ignore' => true,
            'order'          => 20,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('textarea', 'objetivo_solicitacao', array(
            'label'      => 'Objeto do Serviço:',
            'required'   => true,
            'order'          => 21,
        ));

        $this->addElement('textarea', 'justificativa', array(
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

        $this->addElement('text', 'tipo_servicos', array(
            'label'      => 'Descricao:',
            'required'   => true,
            'order'          => 24,
            'class'         => 'campos',
        ));

        $this->addElement('text', 'produto', array(
            'label'      => 'Produto:',
            'required'   => true,
            'order'          => 25,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'numero_itens', array(
            'label'      => 'Qtde:',
            'required'   => true,
            'order'          => 26,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'data_servicos', array(
            'label'      => 'Início do Cronograma:',
            'required'   => true,
            'order'          => 27,
            'class'         => 'campos'
        ));

        $this->addElement('text', 'data_servicos_fim', array(
            'label'      => 'Fim do Cronograma:',
            'required'   => true,
            'order'          => 28,
            'class'         => 'campos'
        ));

        $this->addDisplayGroup(array('tipo_servicos','produto','numero_itens', 'data_servicos', 'data_servicos_fim'), 'individual');

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

        $this->addElement('text', 'valor_real', array(
            'label'      => 'Valor Total do Serviço:',
            'required'   => true,
            'class'      => 'pagamento_campos',
            'order'          => 103,
        ));

        $emtDatePicker1 = new ZendX_JQuery_Form_Element_DatePicker('inicio_execucao');
        $emtDatePicker1->setOrder(104);
        $emtDatePicker1->setRequired(true);
        $emtDatePicker1->setLabel('Início: ');
        $emtDatePicker1->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker1);

        $emtDatePicker2 = new ZendX_JQuery_Form_Element_DatePicker('fim_execucao');
        $emtDatePicker2->setOrder(105);
        $emtDatePicker2->setRequired(true);
        $emtDatePicker2->setLabel('Término: ');
        $emtDatePicker2->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker2);


        $this->addElement('text', 'quantidade_parcelas', array(
            'label'      => 'Qtde de Parcelas:',
            'required'   => true,
            'class'      => 'pagamento_campos',
            'order'          => 106
        ));

        $this->addElement('text', 'valor_parcelas', array(
            'label'      => 'Valor das Parcelas:',
            'required'   => true,
            'class'      => 'pagamento_campos',
            'order'          => 107
        ));

        $emtDatePicker3 = new ZendX_JQuery_Form_Element_DatePicker('data_pagamento');
        $emtDatePicker3->setOrder(108);
        $emtDatePicker3->setRequired(true);
        $emtDatePicker3->setLabel('Data(s) Pagamento: ');
        $emtDatePicker3->setFilters(array('DateFilter'));
        $this->addElement($emtDatePicker3);

        $this->addDisplayGroup(array('valor_real','inicio_execucao','fim_execucao', 'quantidade_parcelas', 'valor_parcelas', 'data_pagamento'), 'individual2');

        $individual2 = $this->getDisplayGroup('individual2');

        $individual2->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'pagamento'))

        ));

        $individual2->setOrder(110);

//        $this->addElement('button', 'add_item_mais_2', array(
//            'label'      => 'Mais',
//            'ignore'   => true,
//            'id'         => 'botao_mais',
//            'attribs' => array('onClick' => 'adicionaCampo2()'),
//            'order'          => 200
//
//        ));
//
//        $this->addElement('button', 'add_item_menos_2', array(
//            'label'      => 'Menos',
//            'ignore'   => true,
//            'id'         => 'botao_menos',
//            'attribs' => array('onClick' => 'removeCampo2()'),
//            'order'          => 201
//        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'order'          => 202,
            'label'    => 'Enviar',
        ));

        //set hidden
        $this->addElement('hidden', 'hidden_teste', array(
            'value'      => '',
            'order'          => 203,
        ));

        //set hidden
        $this->addElement('hidden', 'hidden_teste2', array(
            'value'      => '' ,
            'order'          => 204,
        ));

        $this->addElement('hidden', 'beneficiario_id', array(
            'value'      => '',
            'order'      => 205,
        ));

        $this->addElement('hidden', 'projeto_id', array(
            'value'      => '',
            'order' =>206,
        ));

        $this->addElement('hidden', 'coordenador_tecnico_id', array(
            'value'      => '',
            'order' =>207,
        ));

        $this->addElement('hidden', 'data_solicitacao', array(
            'value' =>  date('Y-m-d', time()),
            'order'          => 208,
        ));


    }

    public function preValidation(array $data) {

        $dados = $_POST;
        $num = $dados['solicitacoes']['hidden_teste'];
        $num2= $dados['solicitacoes']['hidden_teste2'];
        echo "<script>recuperaNum()</script>";
        echo "<script>recuperaNum2()</script>";
        $order = 31;
        $order2= 111;

        for ( $i = 2; $i<=$num ; ++$i) {
        $name1 = "tipo_servicos_". $i;
        $name2 = "produto_". $i;
        $name3 = "numero_itens_". $i;
        $name4 = "data_servicos_". $i;
        $name5 = "data_servicos_fim_". $i;
        $this->addNewField($name1, $dados['solicitacoes'][$name1], $name2 , $dados['solicitacoes'][$name2], $name3,
            $dados['solicitacoes'][$name3], $name4, $dados['solicitacoes'][$name4], $name5, $dados['solicitacoes'][$name5], $order);
        $order = $order + 5;
        }

//        for ( $j=2; $j<=$num2 ; ++$j) {
//        $name1 = "valor_real_". $j;
//        $name2 = "inicio_execucao_". $j;
//        $name3 = "fim_execucao_". $j;
//        $name4 = "quantidade_parcelas_". $j;
//        $name5 = "valor_parcelas_". $j;
//        $name6 = "data_pagamento_". $j;
//        $this->addNewField2($name1, $dados['solicitacoes'][$name1], $name2 , $dados['solicitacoes'][$name2], $name3,
//            $dados['solicitacoes'][$name3], $name4, $dados['solicitacoes'][$name4], $name5, $dados['solicitacoes'][$name5],
//            $name6, $dados['solicitacoes'][$name6], $order2);
//        $order2 = $order2 + 6;
//        }

    }

    public function addNewField($name1, $value1, $name2, $value2, $name3, $value3, $name4, $value4, $name5, $value5, $order) {

        $this->addElement('text', $name1, array(
            'required'       => true,
            'label'          => 'Descrição:',
            'value'          => $value1,
            'class'          => 'campos_maior',
            'order'          => $order,
            'decorators'=> $this->decoratorMaior,
        ));


        $order++;

        $this->addElement('text', $name2, array(
            'required'       => true,
            'label'          => 'Produto:',
            'value'          => $value2,
            'class'          => 'campos_maior',
            'order'          => $order,
            'decorators'=> $this->decoratorMaior,
        ));

        $order++;

        $this->addElement('text', $name3, array(
            'required'       => true,
            'label'          => 'Qtde:',
            'value'          => $value3,
            'class'          => 'campos_menor',
            'order'          => $order,
            'decorators'=> $this->decoratorMenor,
        ));

        $order++;

        $this->addElement('text', $name4, array(
            'required'       => true,
            'label'          => 'Início do Cronograma:',
            'value'          => $value4,
            'class'          => 'campos',
            'order'          => $order
        ));

        $order++;

        $this->addElement('text', $name5, array(
            'required'       => true,
            'label'          => 'Fim do Cronograma',
            'value'          => $value5,
            'class'          => 'campos',
            'order'          => $order
        ));


        $individual = $this->getDisplayGroup('individual');

       $individual->addElements(array ($this->getElement($name1), $this->getElement($name2), $this->getElement($name3),
           $this->getElement($name4), $this->getElement($name5)));

        echo "<script>incNum()</script>";
    }

//    public function addNewField2($name1, $value1, $name2, $value2, $name3, $value3, $name4, $value4, $name5, $value5, $name6, $value6, $order2) {
//
//        $this->addElement('text', $name1, array(
//            'required'       => true,
//            'label'          => 'Valor Total do Serviço:',
//            'value'          => $value1,
//            'class'          => 'pagamento_campos',
//            'order'          => $order2
//        ));
//
//        $order2++;
//
//        $this->addElement('text', $name2, array(
//            'required'       => true,
//            'label'          => 'Início:',
//            'value'          => $value2,
//            'class'          => 'pagamento_campos',
//            'order'          => $order2
//        ));
//
//        $order2++;
//
//        $this->addElement('text', $name3, array(
//            'required'       => true,
//            'label'          => 'Término:',
//            'value'          => $value3,
//            'class'          => 'pagamento_campos',
//            'order'          => $order2
//        ));
//
//        $order2++;
//
//        $this->addElement('text', $name4, array(
//            'required'       => true,
//            'label'          => 'Qtde de Parcelas:',
//            'value'          => $value4,
//            'class'          => 'pagamento_campos',
//            'order'          => $order2
//        ));
//
//        $order2++;
//
//        $this->addElement('text', $name5, array(
//            'required'       => true,
//            'label'          => 'Valor das Parcelas',
//            'value'          => $value5,
//            'class'          => 'pagamento_campos',
//            'order'          => $order2
//        ));
//
//        $order2++;
//
//        $this->addElement('text', $name6, array(
//            'required'       => true,
//            'label'          => 'Data(s) Pagamento',
//            'value'          => $value6,
//            'class'          => 'pagamento_campos',
//            'order'          => $order2
//        ));
//
//
//        $individual2 = $this->getDisplayGroup('individual2');
//
//        $individual2->addElements(array ($this->getElement($name1), $this->getElement($name2), $this->getElement($name3),
//            $this->getElement($name4), $this->getElement($name5), $this->getElement($name6)));
//
//        echo "<script>incNum2()</script>";
//    }
}
?>

    <script>
    var num = 1;
    var margem = 0;
    function adicionaCampo(){
        num++;
        $('#cronograma').append("<dt id='solicitacoes-tipo_servicos-label' style='float:left; margin-left:'" + margem*(num-1) + "px><label " +
                "for='solicitacoes-tipo_servicos_" + num + "' class='required'>Descricao:</label></dt>");
        $('#cronograma').append("<dd id='solicitacoes-tipo_servicos-element'><input type='text' name='solicitacoes[tipo_servicos_"+
                num + "]' id='solicitacoes-tipo_servicos' value='' class='campos'></dd>");
        $('#cronograma').append("<dt id='solicitacoes-produto-label'><label for='solicitacoes-produto_" + num + "' class='required'>" +
                "Produto:</label></dt>");
        $('#cronograma').append("<dd id='solicitacoes-produto-element'><input type='text' name='solicitacoes[produto_"+ num +
                "]' id='solicitacoes-produto' value='' class='campos'></dd>");
        $('#cronograma').append("<dt id='solicitacoes-numero_itens-label'><label for='solicitacoes-numero_itens_" + num + "' class='required'>" +
                "Qtde:</label></dt>");
        $('#cronograma').append("<dd id='solicitacoes-numero_itens-element'><input type='text' name='solicitacoes[numero_itens_"+ num + "]' " +
                "id='solicitacoes-numero_itens' value='' class='campos'></dd>");
        $('#cronograma').append("<dt id='solicitacoes-data_servicos-label'><label for='solicitacoes-data_servicos_" + num + "' " +
                "class='required'>Início do Cronograma:</label></dt>");
        $('#cronograma').append("<dd id='solicitacoes-data_servicos-element'><input type='text' " +
                "name='solicitacoes[data_servicos_"+ num + "]' id='solicitacoes-data_servicos' value='' class='campos'></dd>");
        $('#cronograma').append("<dt id='solicitacoes-data_servicos_fim-label'><label for='solicitacoes-data_servicos_fim_" + num + "' " +
                "class='required'>Fim do Cronograma:</label></dt>");
        $('#cronograma').append("<dd id='solicitacoes-data_servicos_fim-element'><input type='text' " +
                "name='solicitacoes[data_servicos_fim_"+ num + "]' id='solicitacoes-data_servicos_fim' value='' class='campos'></dd>");

        $('#solicitacoes-hidden_teste').attr('value', num);

    }

    function removeCampo(){
        if (num > 1) {
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
        num = 1;
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
    /*
    var num2 = 1;
    var margem = 0;
    function adicionaCampo2(){
        //var x = "' + margem * (num-1) + 'px'>
        num2++;
        $('#pagamento').append("<dt id='solicitacoes-valor_real-label' style='float:left; margin-left:'" + margem*(num-1) + "px><label " +
                "for='solicitacoes-valor_real_" + num2 + "' class='required'>Valor Total do Serviço:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-valor_real-element'><input type='text' name='solicitacoes[valor_real_" + num2 + "]' " +
                "id='solicitacoes-valor_real' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append("<dt id='solicitacoes-inicio_execucao-label'><label for='solicitacoes-inicio_execucao_" + num2 +
                "' class='required'>Início:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-inicio_execucao-element'><input type='text' name='solicitacoes[inicio_execucao_" + num2 + "]' " +
                "id='solicitacoes-inicio_execucao' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append("<dt id='solicitacoes-fim_execucao-label'><label for='solicitacoes-fim_execucao_" + num2 + "' " +
                "class='required'>Término:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-fim_execucao-element'><input type='text' name='solicitacoes[fim_execucao_"+ num2 + "]' " +
                "id='solicitacoes-fim_execucao' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append("<dt id='solicitacoes-quantidade_parcelas-label'><label for='solicitacoes-quantidade_parcelas_" + num2 + "' " +
                "class='required'>Qtde de Parcelas:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-quantidade_parcelas-element'><input type='text' " +
                "name='solicitacoes[quantidade_parcelas_" + num2 + "]' id='solicitacoes-quantidade_parcelas' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append("<dt id='solicitacoes-valor_parcelas-label'><label for='solicitacoes-valor_parcelas_" + num2 + "' " +
                "class='required'>Valor das Parcelas:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-valor_parcelas-element'><input type='text' " +
                "name='solicitacoes[valor_parcelas_"+ num2 + "]' id='solicitacoes-valor_parcelas' value='' class='pagamento_campos'></dd>");
        $('#pagamento').append("<dt id='solicitacoes-data_pagamento-label'><label for='solicitacoes-data_pagamento_" + num2 + "' " +
                "class='required'>Data(s) Pagamento:</label></dt>");
        $('#pagamento').append("<dd id='solicitacoes-data_pagamento-element'><input type='text' " +
                "name='solicitacoes[data_pagamento_"+ num2 + "]' id='solicitacoes-data_pagamento' value='' class='pagamento_campos'></dd>");

        $('#solicitacoes-hidden_teste2').attr('value', num2);


    }

    function removeCampo2(){
        if (num2 > 1) {
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
            $('#solicitacoes-hidden_teste2').attr('value', num2);

        }
    }

    function recuperaNum2(){
        num2 = 1;
        $('#solicitacoes-hidden_teste2').attr('value', num2);
    }

    function incNum2(){
        num2 = num2 + 1;
        $('#solicitacoes-hidden_teste2').attr('value', num2);
    }

    function getNum2(){
        $('#solicitacoes-hidden_teste2').attr('value', num2);
        return num2;
    }
         */
</script>

