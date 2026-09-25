<?php
require_once "config.php";

class Livro
{
    public static function listar($pdo, $busca = "")
    {
        if ($busca != "") {
            $sql = "SELECT * FROM livros 
                    WHERE titulo LIKE :busca OR autor LIKE :busca 
                    ORDER BY titulo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":busca" => "%$busca%"]);
        } else {
            $sql = "SELECT * FROM livros ORDER BY titulo";
            $stmt = $pdo->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscar($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM livros WHERE id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function cadastrar($pdo, $dados)
    {
        $sql = "INSERT INTO livros (titulo, autor, genero, ano_publicacao, quantidade)
                VALUES (:titulo, :autor, :genero, :ano, :qtd)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":titulo" => $dados["titulo"],
            ":autor"  => $dados["autor"],
            ":genero" => $dados["genero"],
            ":ano"    => $dados["ano_publicacao"],
            ":qtd"    => $dados["quantidade"]
        ]);
    }

    public static function atualizar($pdo, $id, $dados)
    {
        $sql = "UPDATE livros SET titulo=:titulo, autor=:autor, genero=:genero,
                ano_publicacao=:ano, quantidade=:qtd WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"     => $id,
            ":titulo" => $dados["titulo"],
            ":autor"  => $dados["autor"],
            ":genero" => $dados["genero"],
            ":ano"    => $dados["ano_publicacao"],
            ":qtd"    => $dados["quantidade"]
        ]);
    }

    public static function excluir($pdo, $id)
    {
        $stmt = $pdo->prepare("DELETE FROM livros WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }

    public static function validar($dados)
    {
        $erros = [];
        $anoAtual = date("Y");

        if (empty(trim($dados["titulo"]))) {
            $erros[] = "O título é obrigatório.";
        }
        if (empty(trim($dados["autor"]))) {
            $erros[] = "O autor é obrigatório.";
        }
        if (!is_numeric($dados["ano_publicacao"]) || $dados["ano_publicacao"] > $anoAtual) {
            $erros[] = "Ano inválido (não pode ser maior que $anoAtual).";
        }
        if (!is_numeric($dados["quantidade"]) || $dados["quantidade"] < 0) {
            $erros[] = "A quantidade não pode ser negativa.";
        }

        return $erros;
    }
}