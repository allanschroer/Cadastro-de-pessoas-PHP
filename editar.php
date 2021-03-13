<?php

#include 'header.php';
include 'db.php';
include 'header.php';

// define variaveis vazias
$nomeErr = $nascimentoErr = $cpfErr = $emailErr = $areaErr = $telefoneErr = "";
$nome = $nascimento = $cpf = $telefone = $email = $cpf_formatado = "";
$soma_verificacao = 0;

if (@$_GET['error'] =='email'){
  $emailErr = "O E-Mail inserido é inválido, verifique.";
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //verifica o nome
  if (empty($_POST["nome"])) {
    $nomeErr = "Nome é um campo obrigatório.";
  } 
  else {
    $nome = testa_input($_POST["nome"]);
    // checa se tem apenas caracteres
    if (!preg_match("/^[a-zA-Z ]*$/",$nome)) {
      $nomeErr = "Apenas letras e espaços são permitidos.";}
      else{
        $soma_verificacao =+1;
      }
    
    }
  //verifica a data de nascimento
    if (empty($_POST["nascimento"])) {
    $nascimentoErr = "Data de nascimento é obrigatório";
  } else {
    $nascimento = testa_input($_POST["nascimento"]);
    $soma_verificacao +=1;
  }


  //verifica o CPF
    if (empty($_POST["cpf"])) {
      $cpfErr = "CPF é obrigatório.";
  } else {
      $cpf = testa_input($_POST["cpf"]);
      //retira qualquer coisa que nao seja numero do cpf
      $cpf = preg_replace("/[^0-9]/","" ,$cpf);

      //coloca pontuação no cpf
      if (strlen($cpf)==11) {
        $bloco_1 = substr($cpf,0,3);
        $bloco_2 = substr($cpf,3,3);
        $bloco_3 = substr($cpf,6,3);
        $dig_verificador = substr($cpf,-2);
        $cpf_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;

        //consulta para verificar duplicidade
        $consulta_cpf = $conexao->query("SELECT * FROM `cadastro` WHERE `cpf` LIKE '$cpf_formatado'");

      if(mysqli_num_rows($consulta_cpf) > 1){
        $cpfErr = "O CPF inserido já existe.";
      }
      else{
        $soma_verificacao +=1;
      }
    }
      else{
        $cpfErr = "O CPF digitado é invalido.";
    }
  

  }
  

  //formata telefone
  $telefone = ($_POST["telefone"]);
  $ver_telefone = preg_replace("/[^0-9]/", "", $telefone);

  if (strlen($ver_telefone)>11){

  }
  elseif (strlen($ver_telefone) < 9) { 
    
  } 
  else{
    $parte_1 = substr($ver_telefone,0,2);
    $parte_2 = substr($ver_telefone, 2,-4);
    $parte_3 = substr($ver_telefone, -4, 4);
    $telefone = "(".$parte_1.")".$parte_2."-".$parte_3;
  }
  



  //verifica o e-mail
  $teste_email = "";
  if ($email = testa_input($_POST["email"]));
    // checagem do e-mail valido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $teste_email = "false";
    }
  }

  //função para testar o input
  function testa_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


while ($linha = mysqli_fetch_array($exibicao)) {?>
<?php 
if ($linha['id_cliente'] == $_GET['id']) {?>

    <h2 class ="espaco_titulo">Editar cadastro:</h2>
    <form method="post" action="">

    <input type="hidden" name ="id_cliente" value ="<?php echo $linha['id_cliente']?>"></input>
    <label>NOME COMPLETO:</label><br>
    <input type="text" name="nome" value="<?php echo $linha['nome']?>">
    <span class="error">* <?php echo $nomeErr;?></span><br><br>

    <label>DATA DE NASCIMENTO:</label><br>
        <input type="text" name="nascimento" placeholder="Data de Nascimento" value="<?php echo $linha['data_nascimento']?>">
    <span class="error">* <?php echo $nascimentoErr;?></span><br><br>

    <label>CPF:</label><br>
    <input type="text" name="cpf" value="<?php echo $linha['cpf']?>">
    <span class="error">* <?php echo $cpfErr;?></span><br><br>

    <label>TELEFONE:</label><br>
    <input type="text" name="telefone" value="<?php echo $linha['telefone']?>">
    <span class="error"><?php echo $telefoneErr;?></span><br><br>
    <label>EMAIL:</label><br>
    <input type="text" name="email" value="<?php echo $linha['email']?>">
    <span class="error"> <?php echo $emailErr;?></span><br><br>
    <input type="submit" value="Atualizar"><br>
<?php

}
}



if ($soma_verificacao >= 3) {
    $id = $_GET['id'];
    $query = "UPDATE `cadastro` SET `nome` = '$nome', `data_nascimento` = '$nascimento', `cpf` = '$cpf_formatado', `telefone` = '$telefone', `email` = '$email' WHERE `cadastro`.`id_cliente` = '$id'";

    if ($teste_email == "false") {
      mysqli_query($conexao, $query);
      header("Refresh:0; url= editar.php?&id=".$id."&error=email");
    }
    else{
      mysqli_query($conexao, $query);
      header("Refresh:0; url= editar.php?&id=".$id."&error=null");
    }
      
  } 

