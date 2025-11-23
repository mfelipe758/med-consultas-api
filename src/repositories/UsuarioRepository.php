<?php

namespace repositories;
use models\Perfil;
use models\PerfilTipo;
use models\Usuario;

class UsuarioRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Usuario $usuario): ?int{
        $sql = "INSERT INTO usuarios (email, senha, ativo, perfil_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $ativo = $usuario->isAtivo();
        $perfilId = $usuario->getPerfil()->getId()->value;
        $stmt->bind_param("ssis", $email, $senha, $ativo, $perfilId);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return null;
    }
    public function buscarPorEmail(string $email): ?Usuario {
        $sql = "SELECT u.*, p.descricao as perfil_descricao 
                FROM usuarios u 
                JOIN perfis p ON u.perfil_id = p.id 
                WHERE u.email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($row = $result->fetch_assoc()){
            $perfil = new Perfil(PerfilTipo::from($row['perfil_id']), $row['perfil_descricao']);
            return new Usuario((int)$row['id'], $row['email'], $row['senha'], (bool)$row['ativo'], $perfil);
        }
        return null;
    }

    public function buscarTodos(): array {
        $sql = "SELECT u.*, p.descricao as perfil_descricao 
                FROM usuarios u 
                JOIN perfis p ON u.perfil_id = p.id";
        $result = $this->conn->query($sql);
        $usuarios = [];
        while ($data = $result->fetch_assoc()) {
            $perfil = new Perfil(PerfilTipo::from($data['perfil_id']), $data['perfil_descricao']);
            $usuarios[] = new Usuario((int)$data['id'], $data['email'], $data['senha'], (bool)$data['ativo'], $perfil);
        }
        return $usuarios;
    }

    public function buscarPorId(int $id): ?Usuario{
        $sql = "SELECT u.*, p.descricao as perfil_descricao 
                FROM usuarios u 
                JOIN perfis p ON u.perfil_id = p.id 
                WHERE u.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $perfil = new Perfil(PerfilTipo::from($row['perfil_id']), $row['perfil_descricao']);
            return new Usuario((int)$row['id'], $row['email'], $row['senha'], (bool)$row['ativo'], $perfil);
        }
        return null;
    }

    public function editar(Usuario $usuario): bool{
        $id = $usuario->getId();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $ativo = $usuario->isAtivo();
        $perfilId = $usuario->getPerfil()->getId()->value;

        $sql = "UPDATE usuarios SET email = ?, senha = ?, ativo = ?, perfil_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ssisi", $email, $senha, $ativo, $perfilId, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}