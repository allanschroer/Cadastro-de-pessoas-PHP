<?php


include 'db.php';
include 'header.php';

#AQUI AINDA FALTA FAZER GARAIO
?>
<h2>Você realemte deseja exlcuir este cadastro?</h2>
<table>
<?php
while ($linha = mysqli_fetch_array($exibicao)) {
    if ($linha['id_cliente'] == $_GET['id']) {
    echo '<tr><td>'.$linha['id_cliente'].'</td>';
    echo '<td>'.$linha['nome'].'</td>';
    echo '<td>'.$linha['data_nascimento'].'</td>';
    echo '<td>'.$linha['cpf'].'</td>';
    echo '<td>'.$linha['telefone'].'</td>';
    echo '<td>'.$linha['email'].'</td>';
    }
}
?></table>
   <?php
   //validação deleção de cadastro
      if(isset($_POST['sim'])) { 
        $id_cliente = $_GET['id'];

        $query = "DELETE FROM cadastro WHERE id_cliente = $id_cliente";
        
        mysqli_query($conexao, $query);
        header('location: index.php'); 
      } 
      if(isset($_POST['nao'])) {
          header('location: index.php'); 
      } 
  ?> 

<form method="post"> 
        <input type="submit" name="sim"
                value="SIM"/> 
          
        <input type="submit" name="nao"
                value="NÃO"/> 
    </form>


