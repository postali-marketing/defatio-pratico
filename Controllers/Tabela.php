<?php

	class Tabela
	{	

		protected function listaAlunos ()
		{
			$json = file_get_contents(MAIN_FOLDER . '/data/alunos.json');
			return json_decode($json, true);
		}

		function buscaDados ($request)
		{
			$listaAlunos = [];

			foreach ($this->listaAlunos() as $id => $dados)
			{
				$listaAlunos[] =
					[
						"id" => $id,
						"nome" => $dados['nome'],
						"turma" => $dados['turma']
					];
			}

			return $listaAlunos;
		}

		function salvaDados ($request)
		{
			$alunos = $this->listaAlunos();

			foreach ($request as $aluno)
			{
				$id = $aluno['id'];
				$alunos[$id]['nome'] = $aluno['nome'];
				$alunos[$id]['turma'] = $aluno['turma'];
			}

			file_put_contents(MAIN_FOLDER . '/data/alunos.json', json_encode($alunos));
		}
	}