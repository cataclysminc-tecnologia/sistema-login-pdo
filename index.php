<?php

require_once 'classes/usuarios.php';
$u = new Usuario;

?>

<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Sistema de Login</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div id="corpo-form">
        <h1>Entrar</h1>
        <form method="POST">
            <input type="email" name="email" placeholder="Usuário">
            <input type="password" name="senha" placeholder="Senha">
            <input type="submit" value="ACESSAR">
            <a href="cadastrar.php">Ainda não tem conta?<strong>Cadastre-se</strong></a>
        </form>
    </div>
    <?php
        if(isset($_POST['email']))
        {
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);

            // verificar se está preenchido
            if(!empty($email) && !empty($senha))
            {
                $u->conectar("tela_login","localhost","root","");
                if($u->msgErro == "")
                {
                    if($u->logar($email, $senha))
                    {
                        header("Location: AreaPrivada.php");
                    } 
                    else 
                    {
                        ?>
                            <div class="msg-erro">
                                Email e/ou senha estão incorretos!
                            </div>
                        <?php
                        
                    }
            } 
            else 
            {
                ?>
                    <div class="msg-erro">
                        <?php echo "Erro: ".$u->msgErro; ?>
                    </div>
                <?php
                
            }
                
            } else 
            
            {
                ?>
                    <div class="msg-erro">
                        Preencha todos os campos!
                    </div>
                <?php
                
            }
        }
    ?>

</body>
</html>