<?php
require_once "config.php";
require_once "Livro.php";

class LivroController
{
    // Mostra a lista (com busca)
    public function index()
    {
        global $pdo;
        $busca = $_GET["busca"] ?? "";
        $livros = Livro::listar($pdo, $busca);
        require "views/lista.php";
    }

    // Formulário de cadastro
    public function criar()
    {
        global $pdo;
        $erros = [];
        $livro = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $livro = $_POST;
            $erros = Livro::validar($livro);

            if (empty($erros)) {
                Livro::cadastrar($pdo, $livro);
                header("Location: index.php?msg=criado");
                exit;
            }
        }
        $acao = "criar";
        require "views/form.php";
    }

    // Formulário de edição
    public function editar()
    {
        global $pdo;
        $id = $_GET["id"] ?? 0;
        $livro = Livro::buscar($pdo, $id);

        if (!$livro) {
            header("Location: index.php");
            exit;
        }

        $erros = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $erros = Livro::validar($_POST);
            if (empty($erros)) {
                Livro::atualizar($pdo, $id, $_POST);
                header("Location: index.php?msg=editado");
                exit;
            }
            $livro = array_merge($livro, $_POST);
        }

        $acao = "editar";
        require "views/form.php";
    }

    // Exclui o livro
    public function excluir()
    {
        global $pdo;
        $id = $_POST["id"] ?? 0;
        if ($id > 0) {
            Livro::excluir($pdo, $id);
        }
        header("Location: index.php?msg=excluido");
        exit;
    }
}