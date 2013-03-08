<?php

class Application_Form_Solicitacoes_AquisicaoBens extends Zend_Form
{

    public $decoratorMaior = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag'=> 'dd', 'class' => 'maior')),
        array('Label', array('tag'=> 'dt', 'class' => 'maior_label')),
        array()
    );

    public function startform()
    {
        $this->setIsArray('true');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setElementsBelongTo('solicitacoes');

        // Setar metodo
        $this->setMethod('post');


        $this->addElement('hidden', 'label_titulo', array(
            'description' => 'Formulário de Aquisição de Bens e Serviços de Pessoa Jurídica',
            'ignore' => true,
            'order'          => 1,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $this->addElement('hidden', 'label_solicitacao', array(
            'description' => '1 - Dados da Solicitação',
            'ignore' => true,
            'order'          => 2,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Data da solicitação
        $this->addElement('text', 'data_solicitacao_view', array(
            'label'      => 'Data da Solicitação:',
            'value'      => date('Y-m-d', time()),
            'disabled'   => true,
            'required'   => false,
            'order'          => 3,
        ));

        //Projeto input type text
        $this->addElement('text', 'projeto', array(
            'label'      => 'Projeto:',
            'required'   => true,
            'order' => 4,
        ));

        //Coordenador do projeto input type text
        $this->addElement('text', 'coodenador_projeto', array(
            'label'      => 'Coordenador do Projeto:',
            'required'   => false,
            'readonly'   => true,
            'ignore'         => true,
            'order'          => 5
        ));



        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => false,
            'readonly'   => true,
            'ignore'         => true,
            'order'          => 6,
        ));

        $this->addElement('text', 'telefone_coordenador', array(
            'label'      => 'Telefone:',
            'required'   => false,
            'readonly'   => true,
            'ignore'         => true,
            'order'          => 7
        ));

        $this->addElement('text', 'celular_coordenador', array(
            'label'      => 'Celular:',
            'required'   => false,
            'readonly'   => true,
            'ignore'         => true,
            'order'          => 8
        ));

        $this->addElement('hidden', 'label_tipo', array(
            'description' => '2 - Tipo de Solicitação',
            'ignore' => true,
            'order'          => 9,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('radio', 'tipo_solicitacao_id', array(
            'label'      => 'Tipo:',
            'multiOptions' => Application_Model_TipoSolicitacao::getOptionsAquisicao(),
            'required'   => true,
            'order'          => 10,
            'id'         => 'radiobutton',
        ));

        $this->addElement('hidden', 'label_descricao', array(
            'description' => '3 - Descrição Detalhada dos Bens/Serviços',
            'ignore' => true,
            'order'          => 11,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('text', 'numero_itens', array(
            'label'      => 'Quantidade:',
            'required'   => true,
            'order'          => 13,
            'class'         => 'campos',
            //'attribs' => array('onblur' => 'calcularTotal(1)'),
        ));

        $this->addElement('textarea', 'solicitacao_nome', array(
            'label'      => 'Descrição:',
            'required'   => true,
            'order'          => 14,
            'class'         => 'campos',
        ));

        $this->addElement('text', 'preco_unidade', array(
            'label'      => 'Preço Unitário:',
            'required'   => true,
            'order'          => 15,
            'class'         => 'campos',
            'attribs' => array('onblur' => 'calcularTotal(1)'),
        ));

        $this->addElement('text', 'valor_estimado', array(
            'label'      => 'Valor Estimado:',
            'required'   => true ,
            'order'          => 16,
            'class'         => 'campos',
        ));

        $this->addDisplayGroup(array('label_item','numero_itens','solicitacao_nome', 'preco_unidade', 'valor_estimado'), 'individual');

        $individual = $this->getDisplayGroup('individual');

        $individual->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'descricao'))

        ));

        $individual->setOrder(17);

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
            'id'         => 'botao_menos',
            'order'          => 101,
            'attribs' => array('onClick' => 'removeCampo()'),


        ));

        $this->addElement('hidden', 'label_justificativa', array(
            'description' => '4 - Importante: Justificativa para Contratação/Aquisição',
            'ignore' => true,
            'order'          => 102,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('textarea', 'justificativa', array(
            'label'      => 'Justificativa:',
            'required'   => true,
            'order'          => 103,
        ));

        $this->addElement('hidden', 'label_sugestoes', array(
            'description' => '5 - Sugestões para Pesquisa de Mercado ou Fornecedores Selecionados',
            'ignore' => true,
            'order'          => 104,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));


        $this->addElement('hidden', 'label_local', array(
            'description' => '6 - Local de Entrega para Bens (Padrão: CDT)',
            'ignore' => true,
            'order'          => 105,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('checkbox','local',array(
            'required' => false,
            'order'          => 106,
            'label' => 'Outro Endereço:',
            'uncheckedValue' => 'cdt',
            'checkedValue' => 'outro',
            'attribs' => array('onChange' => 'tipoLocal(this.value)'),
        ));

        $this->addElement('textarea', 'local_entrega_solicitacao_view', array(
            'label'      => 'Endereço:',
            'required'   => false,
            'value'      => 'CDT',
            'disabled'   => true,
            'order'          => 107,
            'attribs'    => array('onblur' => 'setLocal(this.value)')
        ));

        $this->addElement('text', 'responsavel_entrega', array(
            'label'      => 'Responsável:',
            'required'   => true,
            'order'          => 108,
        ));

        $this->addElement('text', 'telefone_entrega', array(
            'label'      => 'Telefone:',
            'required'   => true,
            'order'          => 109,
        ));

        $this->addElement('hidden', 'label_solicito', array(
            'description' => 'Solicito a aquisição dos bens/serviços na forma acima descrita.',
            'ignore' => true,
            'order'          => 110,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id'=>'internasolicitacao')),
            ),
        ));

        $this->addElement('text', 'beneficiario_id', array(
            'label'      => 'teste:',
            'required'   => true,
            'order'          => 111
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'order'          => 112,
            'label'    => 'Enviar',
        ));

        $this->addElement('hidden', 'data_solicitacao', array(
            'value' =>  date('Y-m-d', time()),
            'order'          => 113,
        ));

        $this->addElement('hidden', 'local_entrega_solicitacao', array(
            'value' =>  'CDT',
            'order'          => 114
        ));

        $this->addElement('hidden', 'hidden_teste', array(
            'value'      => '',
            'order'          => 115,
        ));
        $this->addElement('hidden', 'projeto_id', array(
            'value'      => '',
            'order' =>116,
        ));

        $this->addElement('hidden', 'coordenador_tecnico_id', array(
            'value'      => '',
            'order' =>116,
        ));


    }

    public function preValidation(array $data) {

        $dados = $_POST;
        $num = $dados['solicitacoes']['hidden_teste'];
        echo "<script>recuperaNum()</script>";
        $order = 18;

        for ( $i = 2; $i<=$num ; $i++) {
            $name1 = "numero_itens_". $i;
            $name2 = "solicitacao_nome_". $i;
            $name3 = "preco_unidade_". $i;
            $name4 = "valor_estimado_". $i;
            $this->addNewField($name1, $dados['solicitacoes'][$name1], $name2 , $dados['solicitacoes'][$name2], $name3, $dados['solicitacoes'][$name3],
                               $name4, $dados['solicitacoes'][$name4], $order, $i);
            $order = $order + 4;
        }
    }

    public function addNewField($name1, $value1, $name2, $value2, $name3, $value3, $name4, $value4, $order, $i) {


        $this->addElement('text', $name1, array(
            'required'       => true,
            'label'          => 'Quantidade:',
            'value'          => $value1,
            'class'          => 'campos',
            'order'          => $order,
           // 'attribs' => array('onkeyup' => 'calcularTotal()'),
        ));

        $order++;

        $this->addElement('text', $name2, array(
            'required'       => true,
            'label'          => 'Descrição:',
            'value'          => $value2,
            'class'          => 'campos_maior',
            'order'          => $order,
            'decorators'=> $this->decoratorMaior,
        ));

        $order++;

        $this->addElement('text', $name3, array(
            'required'       => true,
            'label'          => 'Preço Unitário:',
            'value'          => $value3,
            'class'          => 'campos',
            'order'          => $order,
            'attribs' => array('onblur' => 'calcularTotal('.$i.')'),
        ));

        $order++;

        $this->addElement('text', $name4, array(
            'required'       => true,
            'label'          => 'Valor Estimado',
            'value'          => $value4,
            'class'          => 'campos',
            'order'          => $order
        ));


        $individual = $this->getDisplayGroup('individual');
        var_dump($individual);

        $individual->addElements(array ($this->getElement($name1), $this->getElement($name2),
            $this->getElement($name3), $this->getElement($name4)));

        echo "<script>incNum()</script>";
    }

}
?>

<script>
    var num = 1;
    var margem = 0;
    function adicionaCampo(){
        num++;
        $('#descricao').append("<dt id='solicitacoes-numero_itens-label'><label class='required' " +
            "for='solicitacoes-numero_itens_" + num + "'>Quantidade:</label></dt>");
        $('#descricao').append("<dd id='solicitacoes-numero_itens-element'><input id='solicitacoes-numero_itens' " +
            "class='campos' type='text' value='' name='solicitacoes[numero_itens_" + num + "]'></dd>");
        $('#descricao').append("<dt id='solicitacoes-solicitacao_nome-label'><label class='required' " +
                "for='solicitacoes-solicitacao_nome_" + num + "'>Descrição:</label></dt>");
        $('#descricao').append("<dd id='solicitacoes-solicitacao_nome-element'><textarea id='solicitacoes-solicitacao_nome' " +
                "class='campos' cols='80' rows='24' name='solicitacoes[solicitacao_nome_" + num + "]'></textarea></dd>");
        $('#descricao').append("<dt id='solicitacoes-preco_unidade-label'><label class='optional' " +
                "for='solicitacoes-preco_unidade_" + num + "'>Preço Unitário:</label></dt>");
        $('#descricao').append("<dd id='solicitacoes-preco_unidade-element'><input id='solicitacoes-preco_unidade' " +
                "class='campos' type='text' value='' onblur='calcularTotal("+num+")' name='solicitacoes[preco_unidade_" + num + "]'></dd>");
        $('#descricao').append("<dt id='solicitacoes-valor_estimado-label'><label class='required' " +
                "for='solicitacoes-valor_estimado_" + num + "'>Valor Estimado:</label></dt>");
        $('#descricao').append("<dd id='solicitacoes-valor_estimado-element'><input id='solicitacoes-valor_estimado' " +
                "class='campos' type='text' name='solicitacoes[valor_estimado_" + num + "]'></dd>");

        $('#solicitacoes-hidden_teste').attr('value', num);
         //onblur='calcularTotal("+num+")'
        }

    function removeCampo(){
        if (num > 1) {
        $('#descricao dd:last-child').remove();
        $('#descricao dt:last-child').remove();
        $('#descricao dd:last-child').remove();
        $('#descricao dt:last-child').remove();
        $('#descricao dd:last-child').remove();
        $('#descricao dt:last-child').remove();
        $('#descricao dd:last-child').remove();
        $('#descricao dt:last-child').remove();

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

