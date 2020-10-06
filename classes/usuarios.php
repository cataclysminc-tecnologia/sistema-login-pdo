<?php

Class Usuario
{
    public $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $usuario, $senha)
    {
        global $pdo;
        global $msgErro;
        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
        
    }

    public function cadastrar($nome, $telefone, $email, $senha)
    {
        global $pdo;

        //var_dump($pdo);

        // Verificar se já existe o email cadastrado
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            return false; // já está cadastrada
        } else {
            // caso não, cadastrar
            $sql = $pdo->prepare("INSERT INTO usuario (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha));

            $sql->execute();

            return true;
        }


        
    }

    public function logar($email, $senha)
    {
        global $pdo;

        // verificar se o email e senha estão cadastrados, se sim
        $sql = $pdo->prepare("select id_usuario from usuarios where email = :e and senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5($senha));
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            // entrar no sistema (sessao)
            $dado = $sql->fetch(); // transformando em array os dados vindo do banco de dados
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; //logado com sucesso
        } else {
            return false; // não foi possível logar
        }

        // entrar no sistema (sessao)
    }

}