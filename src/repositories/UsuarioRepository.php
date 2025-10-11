<?php

namespace repositories;
use models\Usuario;

class UsuarioRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Usuario $usuario): bool{
        $sql = "INSERT INTO usuarios (email, senha, ativo) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $ativo = $usuario->isAtivo();
        $stmt->bind_param("ssi", $email, $senha, $ativo);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM usuarios");
        $usuarios = [];
        while ($data = $result->fetch_assoc()) {
            $usuarios[] = new Usuario((int)$data['id'], $data['email'], $data['senha'], (bool)$data['ativo']);
        }
        return $usuarios;
    }

    public function buscarPorId(int $id): ?Usuario{
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Usuario((int)$row['id'], $row['email'], $row['senha'], (bool)$row['ativo']);
        }
        return null;
    }

    public function editar(Usuario $usuario): bool{
        $id = $usuario->getId();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $ativo = $usuario->isAtivo();
        $sql = "UPDATE usuarios SET email = ?, senha = ?, ativo = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $email, $senha, $ativo, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}