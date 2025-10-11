<?php

namespace repositories;
use models\Especialidade;

class EspecialidadeRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Especialidade $especialidade): bool{
        $sql = "INSERT INTO especialidades (titulo, descricao) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $titulo = $especialidade->getTitulo();
        $descricao = $especialidade->getDescricao();
        $stmt->bind_param("ss", $titulo, $descricao);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM especialidades");
        $especialidades = [];
        while ($data = $result->fetch_assoc()) {
            $especialidades[] = new Especialidade((int)$data['id'], $data['titulo'], $data['descricao']);
        }
        return $especialidades;
    }

    public function buscarPorId(int $id): ?Especialidade{
        $sql = "SELECT * FROM especialidades WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Especialidade((int)$row['id'], $row['titulo'], $row['descricao']);
        }
        return null;
    }

    public function editar(Especialidade $especialidade): bool{
        $id = $especialidade->getId();
        $titulo = $especialidade->getTitulo();
        $descricao = $especialidade->getDescricao();
        $sql = "UPDATE especialidades SET titulo = ?, descricao = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $titulo, $descricao, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM especialidades WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}