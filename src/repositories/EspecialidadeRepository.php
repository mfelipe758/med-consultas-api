<?php

namespace repositories;
use models\Especialidade;
use models\Medico;

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
            $medicos = $this->buscarMedicosPorEspecialidade((int)$data['id']);
            $especialidades[] = new Especialidade((int)$data['id'], $data['titulo'], $data['descricao'], $medicos);
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
            $medicos = $this->buscarMedicosPorEspecialidade((int)$row['id']);
            return new Especialidade((int)$row['id'], $row['titulo'], $row['descricao'], $medicos);
        }
        return null;
    }

    private function buscarMedicosPorEspecialidade(int $especialidadeId): array {
        $sql = "SELECT m.* FROM medicos m
                JOIN medicos_tem_especialidades mte ON m.id = mte.id_medico
                WHERE mte.id_especialidade = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $especialidadeId);
        $stmt->execute();
        $result = $stmt->get_result();

        $medicos = [];
        while ($row = $result->fetch_assoc()) {
            $medicos[] = new Medico(
                (int)$row['id'],
                $row['nome'],
                (int)$row['crm'],
                $row['data_inscricao'],
                (int)$row['endereco_id'],
                (int)$row['usuario_id']
            );
        }
        return $medicos;
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