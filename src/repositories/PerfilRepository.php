<?php

namespace repositories;
use models\Perfil;

class PerfilRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM perfis");
        $perfis = [];
        while ($data = $result->fetch_assoc()) {
            $perfis[] = new Perfil($data['id'], $data['descricao']);
        }
        return $perfis;
    }

    public function buscarPorId(string $id): ?Perfil{
        $sql = "SELECT * FROM perfis WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Perfil($row['id'], $row['descricao']);
        }
        return null;
    }
}