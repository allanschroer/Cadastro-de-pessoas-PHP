
<?php
include 'header.php';
include 'db.php';

// define variaveis
$nomeErr = $nascimentoErr = $cpfErr = $emailErr = "";
$nome = $nascimento = $cpf = $telefone = $email = $cpf_formatado = "";
$soma_verificacao = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //verifica o nome
  if (empty($_POST["nome"])) {
    $nomeErr = "Nome é um campo obrigatório.";
  } else {
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

    if (strlen($cpf)==11) {
      $bloco_1 = substr($cpf,0,3);
      $bloco_2 = substr($cpf,3,3);
      $bloco_3 = substr($cpf,6,3);
      $dig_verificador = substr($cpf,-2);
      $cpf_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;


      $consulta_cpf = $conexao->query("SELECT * FROM `cadastro` WHERE `cpf` LIKE '$cpf_formatado'");

      if(mysqli_num_rows($consulta_cpf) > 0){
        $cpfErr = "O CPF inserido já existe.";
      }
      else{
        $soma_verificacao +=1;
    }}
    else{
      $cpfErr = "O CPF digitado é invalido.";
    }
    //coloca pontuação no cpf

  }
  //coloca mascara no telefone



  //verifica o e-mail
  if ($email = testa_input($_POST["email"]));
    // checagem do e-mail valido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "E-Mail precisa ser válido.";
      $email = "";
    }

}

function testa_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



// FORMULARIO DE CADASTRO?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label>NOME COMPLETO:</label><br>
  <input type="text" name="nome" placeholder="Nome do cadastro">
  <span class="error">* <?php echo $nomeErr;?></span><br><br>
  <label>DATA DE NASCIMENTO:</label><br>
  <input type="text" name="nascimento" placeholder="Data de Nascimento">
  <span class="error">* <?php echo $nascimentoErr;?></span><br><br>
  <label>CPF:</label><br>
  <input type="text" name="cpf" placeholder="Nº do CPF">
  <span class="error">* <?php echo $cpfErr;?></span><br><br>
  <label>TELEFONE:</label><br>
  <input type="text" name="telefone" placeholder="Telefone com área"><br><br>
  <label>EMAIL:</label><br>
  <input type="text" name="email" placeholder="E-mail">
  <span class="error"> <?php echo $emailErr;?></span><br><br>
  <input type="submit" value="Cadastrar"><br>


</form>




<?php



//CHECAGEM DE CAMPOS PREENCHIDOS
if ($soma_verificacao >= 3) {
  $query = "INSERT INTO `cadastro` (`id_cliente`, `nome`, `data_nascimento`, `cpf`, `telefone`, `email`) VALUES (NULL, '$nome', '$nascimento', '$cpf_formatado', '$telefone', '$email')";
  mysqli_query($conexao, $query);


  //teste git
} ?>
