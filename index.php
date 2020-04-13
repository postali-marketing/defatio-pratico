<!DOCTYPE html>
<html>
<head>
	<title>Lista de alunos</title>
	<script type="text/javascript" src="public/js/knockout-3.5.1.js"></script>
	<script type="text/javascript" src="public/js/request.js"></script>
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/bootstrap-grid.min.css">
	<style>
		
		body{
			position: relative;
			margin:0 auto;
			font-family: sans-serif;
		}
		h1{
			margin: 45px auto;
    		text-align: center;
		}
		.container{
			width: 100%;
			max-width: 1040px;
			margin: 0 auto;
		}

	</style>
</head>
<body>
	
	<div id="tabela" class="container">

		<h1>Lista de alunos</h1>

		<p data-bind="hidden: alunos().length > 0">Carregando...</p>


		<table data-bind="hidden: alunos().length == 0" class="table">
			<thead  class="thead-light">
				<tr>
					<th>Nome</th>
					<th>Turma</th>
					<th></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: alunos">
				<tr>
					<td>
						<span data-bind="text: nome, hidden: editando"></span>
						<input class="form-control" type="text" data-bind="hidden: !editando(), value: nome">
					</td>
					<td>
						<span data-bind="text: turma, hidden: editando"></span>
						<input class="form-control" type="text" data-bind="hidden: !editando(), value: turma">
					</td>
					<td>
						<button data-bind="click: editar, hidden: editando()" class="btn btn-light">Editar</button>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<button data-bind="click:salvar" class="btn btn-success">Salvar alterações</button>
					</td>
				</tr>				
			</tfoot>
		</table>

	</div>


	<script type="text/javascript">
		
		Aluno = function (dados)
		{
			let self = this;
			self.nome = ko.observable(dados.nome ? dados.nome : '');
			self.turma = ko.observable(dados.turma ? dados.turma : '');
			self.id = ko.observable(dados.id ? dados.id : null);
			
			self.editando = ko.observable(false);

			self.editar = function()
			{
				self.editando(true);
			}
		}

		TabelaModel = function ()
		{
			let self = this;

			self.alunos = ko.observableArray();

			self.carregar = function ()
			{
				callback = function (resposta)
				{
					if(resposta.status != 200)
						return alert("Houve um erro ao carregar!");

					let alunos = ko.utils.arrayMap(resposta.data, function(aluno){
						return new Aluno(aluno);
					});
					self.alunos(alunos);
				}
				request('Tabela', 'buscaDados', callback);
			}

			self.salvar = function ()
			{
				listaAlunos = ko.utils.arrayMap(self.alunos(), function(aluno){
					return {
						nome: aluno.nome(),
						turma: aluno.turma(),
						id: aluno.id()
					}		
				});

				self.alunos([]);

				callback = function (resposta)
				{
					if(resposta.status != 200)
						return alert("Houve um erro ao editar!");

					self.carregar();
				}
				request('Tabela', 'salvaDados', callback, listaAlunos);
			}
		}

		var tabela = new TabelaModel();
		ko.applyBindings(tabela, document.getElementById('tabela'));
		tabela.carregar();

	</script>
</body>
</html>