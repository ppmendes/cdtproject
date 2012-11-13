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

        $this->addElement('hidden', 'label_justificativa', array(
            'description' => '4 - Importante: Justificativa para Contratação/Aquisição',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('hidden', 'label_sugestoes', array(
            'description' => '5 - Sugestões para Pesquisa de Mercado ou Fornecedores Selecionados',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
        ));

        $this->addElement('hidden', 'label_local', array(
            'description' => '6 - Local de Entrega (para Bens)',
            'ignore' => true,
            'decorators' => array(
                array('Description', array('escape'=>false)),
            ),
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

    }
}
