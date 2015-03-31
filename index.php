<?php
	include "config.php";
?>
<!DOCTYPE HTML>
<html land="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Curso PDO</title>
  <meta name="description" content="Curso PDO" />
  <meta name="robots" content="index, follow" />
   <meta name="author" content="Jose Roberto de Oliveira"/>
   <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" />
  <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
   <![endif]-->
</head>
<body>

	<div class="container">

		<header class="masthead">
			<h1 class="muted">PDO na Prática</h1>
			<nav class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="active"><a href="index.php">Página inicial</a></li>
							<li><a href="">Inserir</a></li>
							<li><a href="">Ler</a></li>
							<li><a href="">Atualizar</a></li>
							<li><a href="">Excluir</a></li>
						</ul>
					</div>
				</div>
			</nav>

			<!--Bloco de código para inserir (CREATE)os dados cadastrados-->
			<?php
				if (isset($_POST['enviar'])){

					$nome = $_POST['nome'];
					$email = $_POST['email'];

					$sql = 'INSERT INTO cadastro (nome, email)';
					$sql .= 'VALUES (:nome, :email)';

					try{
						$create = $db->prepare($sql);
						$create->bindValue(':nome', $nome, PDO::PARAM_STR);
						$create->bindValue(':email', $email, PDO::PARAM_STR);
						if($create->execute()){
							echo "<div class='alert alert-success'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>
							<strong>Inserido com sucesso!</strong>
							</div>";
						}
					}catch (PDOException $e){
						echo "<div class='alert alert-error'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>
							<strong>Erro ao inserir dados!</strong>" . $e->getMessage() ."
							</div>";
					}
				}
				# UPDATE
				if(isset($_POST['atualizar'])){
					$id = (int)$_GET['ID'];
					$nome = $_POST['nome'];
					$email = $_POST['email'];

					$sqlUpdade = 'UPDATE cadastro SET nome = :nome, email = :email WHERE ID = :ID';

					try {
						$update = $db->prepare($sqlUpdade);
						$update->bindValue(':ID', $id, PDO::PARAM_INT);
						$update->bindValue(':nome', $nome, PDO::PARAM_STR);
						$update->bindValue(':email', $email, PDO::PARAM_STR);
						if($update->execute()){
							echo "<div class='alert alert-success'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>
							<strong>Deletado com sucesso!</strong>
							</div>";
						}						 	
					 } catch (PDOException $e) {
					 	echo "<div class='alert alert-error'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>
							<strong>Erro ao deletar dados dados!</strong>" . $e->getMessage() ."
							</div>";
					 } 
				}

				#DELETE
				if(isset($_GET['action']) && $_GET['action'] == 'delete'){
					$id = (int)$_GET['ID'];

					$sqlDelete = 'DELETE FROM cadastro WHERE ID = :ID';

					try {
						$delete = $db->prepare($sqlDelete);
						$delete->bindValue(':ID', $id, PDO::PARAM_INT);
						if($delete->execute()){
							echo "<div class='alert alert-success'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>
							<strong>Atualizado com sucesso!</strong>
							</div>";
						}
					} catch (Exception $e) {
						echo "<div class='alert alert-error'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>
							<strong>Erro ao atualizar dados dados!</strong>" . $e->getMessage() ."
							</div>";	
					}
				}
			?>
		</header>

		<article>
			
			<section class="jumbotron">
				<?php
					if(isset($_GET['action']) && $_GET['action'] == 'update'){
						
						/*Carrega os dados selecionados nos inputs*/
						$id = (int)$_GET['ID'];
						
						$sqlSelect = 'SELECT * FROM cadastro WHERE ID = :ID';

						try {
							$select = $db->prepare($sqlSelect);
							$select->bindValue(':ID', $id, PDO::PARAM_INT);
							$select->execute();
						} catch (PDOException $e) {
							echo $e->getMessage();
						}

						$result = $select->fetch(PDO::FETCH_OBJ);
				?>	
				<form method="post" action="">
			
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input type="text" name="nome" value="<?php echo $result->nome?>" placeholder="Nome:" />
					</div>
			
					<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input type="text" name="email" value="<?php echo $result->email?>" placeholder="E-mail:" />
					</div><br />
					
					<input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">					
				</form>
	
					<?php }else{

					
				?>
				<ul class="breadcrumb">
					<li><a href="index.php">Página inicial <span class="divider"> /</span> </a></li>
					<li class="active">Atualizar</li>
				</ul>

				


				<form method="post" action="">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input type="text" name="nome" placeholder="Nome:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input type="text" name="email" placeholder="E-mail:" />
					</div>
					<br />
					<input type="submit" name="enviar" class="btn btn-primary" value="Cadastrar dados">					
				</form>

				<?php } ?>

				<table class="table table-hover">
					
					<thead>
						<tr>
							<th>#</th>
							<th>Nome:</th>
							<th>E-mail:</th>
							<th>Ações:</th>
						</tr>
					</thead>

					<tbody>
						<!--Bloco de código Leitura (Ready)-->
						<?php
							$sqlRead = 'SELECT * FROM cadastro';
							try{
								$read = $db->prepare($sqlRead);
								$read->execute();	
							}catch(PDOException $e){
								echo $e->getMessage();
							}
							while( $rs = $read->fetch(PDO::FETCH_OBJ) ){
							?>	
								<tr>
									<td><?php echo $rs->ID?></td>
									<td><?php echo $rs->nome?></td>
									<td><?php echo $rs->email?></td>
									<td>
										<a href="index.php?action=update&ID=<?php echo $rs->ID; ?>" class="btn"><i class="icon-pencil"></i></a>
										<a href="index.php?action=delete&ID=<?php echo $rs->ID?>" class="btn" onclick="return confirm('Deseja realmente deletar?')"><i class="icon-remove"></i></a>
									</td>
								</tr>
							<?php }
							?>
					</tbody>

				</table>
				
			</section>

		</article>

	</div>

	<script src="js/jQuery.js"></script>
	<script src="js/bootstrap.js"></script>
</body>
</html>
