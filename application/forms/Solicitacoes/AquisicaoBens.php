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

    public function init()
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
        $this->addElement('select', 'projeto_id', array(
            'label'      => 'Projeto:',
            'multiOptions' => Application_Model_Projeto::getOptions(),
            'required'   => true,
            'order'          => 4
        ));

        //Coordenador do projeto input type text
        $this->addElement('select', 'coodenador_projeto', array(
            'label'      => 'Coordenador do Projeto:',
            'multiOptions' => Application_Model_Usuario::getOptions(),
            'required'   => true,
            'order'          => 5
        ));

        $this->addElement('text', 'email', array(
            'label'      => 'E-mail:',
            'required'   => true,
            'order'          => 6
        ));

        $this->addElement('text', 'telefone', array(
            'label'      => 'Telefone:',
            'required'   => true,
            'order'          => 7
        ));

        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
            'required'   => false,
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


        $this->addElement('hidden', 'label_item', array(
            'description' => '1',
            'ignore' => true,
            'order'          => 12,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id'=>'item', 'class'=>'campos')),
            ),
        ));

        $this->addElement('text', 'numero_itens', array(
            'label'      => 'Quantidade:',
            'required'   => true,
            'order'          => 13,
            'class'         => 'campos'
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
        ));

        $this->addElement('text', 'valor_estimado', array(
            'label'      => 'Valor Estimado:',
            'required'   => true ,
            'order'          => 16,
            'class'         => 'campos'
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

        $this->addElement('text', 'coordenador_projeto', array(
            'label'      => 'Responsável:',
            'required'   => true,
            'order'          => 108,
        ));

        $this->addElement('text', 'telefone_responsavel', array(
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

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'order'          => 111,
            'label'    => 'Enviar',
        ));

        $this->addElement('hidden', 'data_solicitacao', array(
            'value' =>  date('Y-m-d', time()),
            'order'          => 112,
        ));

        $this->addElement('hidden', 'local_entrega_solicitacao', array(
            'value' =>  'CDT',
            'order'          => 113
        ));

        $this->addElement('hidden', 'hidden_teste', array(
            'value'      => '',
            'order'          => 114,
        ));


    }

    public function preValidation(array $data) {

        $dados = $_POST;
        $num = $dados['solicitacoes']['hidden_teste'];
        echo "<script>recuperaNum()</script>";
        $order = 31;

        for ( $i = 2; $i<=$num ; $i++) {
            $name2 = "numero_itens_". $i;
            $name3 = "qtde_". $i;
            $name4 = "cronograma_inicio_". $i;
            $name5 = "cronograma_termino_". $i;
            $this->addNewField($num, $name2 , $dados['solicitacoes'][$name2], $name3, $dados['solicitacoes'][$name3],
                               $name4, $dados['solicitacoes'][$name4], $name5, $dados['solicitacoes'][$name5], $order);
            $order = $order + 5;
        }
    }

    public function addNewField($num, $name2, $value2, $name3, $value3, $name4, $value4, $name5, $value5, $order) {

        $this->addElement('hidden', 'label_item', array(
            'description' => $num,
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id'=>'item', 'class'=>'campos')),
            ),
        ));

        $order++;

        $this->addElement('text', $name2, array(
            'required'       => true,
            'label'          => 'Quantidade:',
            'value'          => $value2,
            'class'          => 'campos',
            'order'          => $order,
        ));

        $order++;

        $this->addElement('text', $name3, array(
            'required'       => true,
            'label'          => 'Descrição:',
            'value'          => $value3,
            'class'          => 'campos_maior',
            'order'          => $order,
            'decorators'=> $this->decoratorMaior,
        ));

        $order++;

        $this->addElement('text', $name4, array(
            'required'       => true,
            'label'          => 'Preço Unitário:',
            'value'          => $value4,
            'class'          => 'campos',
            'order'          => $order
        ));

        $order++;

        $this->addElement('text', $name5, array(
            'required'       => true,
            'label'          => 'Valor Estimado',
            'value'          => $value5,
            'class'          => 'campos',
            'order'          => $order
        ));


        $individual = $this->getDisplayGroup('individual');

        $individual->addElements(array ($this->getElement('label_item'), $this->getElement($name2), $this->getElement($name3),
            $this->getElement($name4), $this->getElement($name5)));

        echo "<script>incNum()</script>";
    }

}
?>

<script>
    var num = 1;
    var margem = 0;
    function adicionaCampo(){
        num++;
        $('#descricao').append("<p id='item' class='campos' style='float:left; margin-left:" + margem*(num-1) + "px'>"+ num + "</p>");
        $('#descricao').append('<dt id="solicitacoes-numero_itens-label"><label class="required" ' +
            'for="solicitacoes-numero_itens">Quantidade:</label></dt>');
        $('#descricao').append('<dd id="solicitacoes-numero_itens-element"><input id="solicitacoes-numero_itens" ' +
            'class="campos" type="text" value="" name="solicitacoes[numero_itens]"></dd>');
        $('#descricao').append('<dt id="solicitacoes-solicitacao_nome-label"><label class="required" ' +
                'for="solicitacoes-solicitacao_nome">Descrição:</label></dt>');
        $('#descricao').append('<dd id="solicitacoes-solicitacao_nome-element"><textarea id="solicitacoes-solicitacao_nome" ' +
                'class="campos" cols="80" rows="24" name="solicitacoes[solicitacao_nome]"></textarea></dd>');
        $('#descricao').append('<dt id="solicitacoes-preco_unidade-label"><label class="optional" ' +
                'for="solicitacoes-preco_unidade">Preço Unitário:</label></dt>');
        $('#descricao').append('<dd id="solicitacoes-preco_unidade-element"><input id="solicitacoes-preco_unidade" ' +
                'class="campos" type="text" value="" name="solicitacoes[preco_unidade]"></dd>');
        $('#descricao').append('<dt id="solicitacoes-valor_estimado-label"><label class="required" ' +
                'for="solicitacoes-valor_estimado">Valor Estimado:</label></dt>');
        $('#descricao').append('<dd id="solicitacoes-valor_estimado-element"><input id="solicitacoes-valor_estimado" ' +
                'class="campos" type="text" value="" name="solicitacoes[valor_estimado]"></dd>');

        $('#solicitacoes-hidden_teste').attr('value', num);

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
        $('#descricao p:last-child').remove();

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

