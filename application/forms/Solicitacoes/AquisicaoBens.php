<?php

class Application_Form_Solicitacoes_AquisicaoBens extends Zend_Form
{

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
            'decorators' => array(
                array('Description', array('escape'=>false, 'id' => 'titulo')),
            ),
        ));

        $this->addElement('hidden', 'label_solicitacao', array(
            'description' => '1 - Dados da Solicitação',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        //Data da solicitação
        $this->addElement('text', 'data_solicitacao_view', array(
            'label'      => 'Data da Solicitação:',
            'value'      => date('Y-m-d', time()),
            'disabled'   => true,
            'required'   => false
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

        $this->addElement('hidden', 'label_tipo', array(
            'description' => '2 - Tipo de Solicitação',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('radio', 'tipo_solicitacao_id', array(
            'label'      => 'Tipo:',
            'multiOptions' => Application_Model_TipoSolicitacao::getOptionsAquisicao(),
            'required'   => true,
            'id'         => 'radiobutton',
        ));

        $this->addElement('hidden', 'label_descricao', array(
            'description' => '3 - Descrição Detalhada dos Bens/Serviços',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));


        $this->addElement('hidden', 'label_item', array(
            'description' => '1',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id'=>'item', 'class'=>'campos')),
            ),
        ));

        $this->addElement('text', 'numero_itens', array(
            'label'      => 'Quantidade:',
            'required'   => true,
            'class'         => 'campos'
        ));

        $this->addElement('textarea', 'solicitacao_nome', array(
            'label'      => 'Descrição:',
            'required'   => true,
            'class'         => 'campos',
        ));

        $this->addElement('text', 'preco_unidade', array(
            'label'      => 'Preço Unitário:',
            'required'   => false,
            'class'         => 'campos',
        ));

        $this->addElement('text', 'valor_estimado', array(
            'label'      => 'Valor Estimado:',
            'required'   => true ,
            'class'         => 'campos'
        ));

        $this->addDisplayGroup(array('label_item','numero_itens','solicitacao_nome', 'preco_unidade', 'valor_estimado'), 'individual');
        $label = $this->getElement('label_item');
        $itens = $this->getElement('numero_itens');
        $desc  = $this->getElement('solicitacao_nome');
        $preco = $this->getElement('preco_unidade');
        $valor = $this->getElement('valor_estimado');

        $individual = $this->getDisplayGroup('individual');

        $individual->setDecorators(array(
            'FormElements',
            array('HtmlTag',array('tag'=>'div','id'=>'descricao'))

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

        $this->addElement('hidden', 'label_justificativa', array(
            'description' => '4 - Importante: Justificativa para Contratação/Aquisição',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('textarea', 'justificativa', array(
            'label'      => 'Justificativa:',
            'required'   => true,
        ));

        $this->addElement('hidden', 'label_sugestoes', array(
            'description' => '5 - Sugestões para Pesquisa de Mercado ou Fornecedores Selecionados',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));


        $this->addElement('hidden', 'label_local', array(
            'description' => '6 - Local de Entrega para Bens (Padrão: CDT)',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('checkbox','local',array(
            'required' => false,
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
            'attribs'    => array('onblur' => 'setLocal(this.value)')
        ));

        $this->addElement('text', 'coordenador_projeto', array(
            'label'      => 'Responsável:',
            'required'   => true,
        ));

        $this->addElement('text', 'telefone_responsavel', array(
            'label'      => 'Telefone:',
            'required'   => true,
        ));

        $this->addElement('hidden', 'label_solicito', array(
            'description' => 'Solicito a aquisição dos bens/serviços na forma acima descrita.',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false, 'id'=>'internasolicitacao')),
            ),
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
        ));

        $this->addElement('hidden', 'data_solicitacao', array(
            'value' =>  date('Y-m-d', time()),
        ));

        $this->addElement('hidden', 'local_entrega_solicitacao', array(
            'value' =>  'CDT',
        ));


    }

//    public function add(){
//        $this->addElement('text', 'campo_teste', array(
//            'label'      => 'Teste:',
//            'required'   => true,
//        ));
//    }
}
?>

<script>
    var num = 2;
    var margem = 0;
    function adicionaCampo(){
        //var x = "' + margem * (num-1) + 'px'>
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
        num++;
        }

    function removeCampo(){
        if (num > 2) {
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
        }
    }
</script>

