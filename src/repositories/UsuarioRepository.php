<?php

namespace repositories;

use models\Usuario;

class UsuarioRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }
    public function criar(Usuario $usuario): bool{
        $sql = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $stmt->bind_param("ss", $email, $senha);
        return $stmt->execute();
    }
    public function buscarPorEmail(String $email): ?Usuario{
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Usuario((int)$row['id'], $row['email'], $row['senha'], $row['ativo']);
        }
        return null;
    }

    public function editar(Usuario $usuario): bool{
        $id = $usuario->getId();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $sql = "UPDATE usuarios SET email = ?, senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $senha, $id);
        return $stmt->execute();

    }
    public function deletar(int $id): bool{
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

}