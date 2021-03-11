		<div>
			<div>
				<table>
					<tr>
						<th>ID do cadastro</th>
						<th>Nome completo</th>
						<th>Data de nascimento</th>
						<th>CPF</th>
						<th>Telefone</th>
						<th>E-Mail</th>
						<th>Editar</th>
						<th>Deletar</th>

					</tr>

					<?php

						while ($linha = mysqli_fetch_array($exibicao)) {
							echo '<tr><td>'.$linha['id_cliente'].'</td>';
							echo '<td>'.$linha['nome'].'</td>';
							echo '<td>'.$linha['data_nascimento'].'</td>';
							echo '<td>'.$linha['cpf'].'</td>';
							echo '<td>'.$linha['telefone'].'</td>';
							echo '<td>'.$linha['email'].'</td>';
							echo '<td><a href="editar.php&id='.$linha['id_cliente'].'"><button>Editar</button></td>';
							echo '<td><a href="deletar.php&id='.$linha['id_cliente'].'"><button>Deletar</button></td>';
						}

					?>
					

				</table>
			</div>
		</div>
	</body>
</html>