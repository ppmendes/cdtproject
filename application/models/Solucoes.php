<?php

class Application_Model_Solucoes
{
	/**
	* Busca a Solução e seus respectivos relacionamentos pelo ID da solução
	* Retorna um array com a Solução
	*/
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Solucoes;
		$solucao = $table->find($id)->current();

		//Relacionamentos
		$fase_desenvolvimento = $solucao->findParentApplication_Model_DbTable_FasesDesenvolvimentos();

		$depositos = $solucao->findApplication_Model_DbTable_Depositos();

		$modalidades = $solucao->findApplication_Model_DbTable_ModalidadesProtecoesViaApplication_Model_DbTable_SolucoesModalidadesProtecoes();
		$oportunidades = $solucao->findApplication_Model_DbTable_OportunidadesViaApplication_Model_DbTable_SolucoesOportunidades();
		$classificacoes = $solucao->findApplication_Model_DbTable_ClassificacoesViaApplication_Model_DbTable_SolucoesClassificacoes();

		$solucao = array(
			'solucao' => $solucao->toArray(),
			'fase_desenvolvimento' => $fase_desenvolvimento->toArray(),
			'depositos' => $depositos,
			'modalidades' => $modalidades->toArray(),
			'oportunidades' => $oportunidades->toArray(),
			'classificacoes' => $classificacoes->toArray(),
		);

		return $solucao;
	}
}

