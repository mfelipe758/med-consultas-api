<?php

namespace repositories;
use models\Paciente;

class PacienteRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Paciente $paciente): bool{
        $sql = "INSERT INTO pacientes (nome, cpf, data_nascimento, endereco_id, usuario_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $nome = $paciente->getNome();
        $cpf = $paciente->getCpf();
        $dataNascimento = $paciente->getDataNascimento();
        $enderecoId = $paciente->getEnderecoId();
        $usuarioId = $paciente->getUsuarioId();
        $stmt->bind_param("sssii", $nome, $cpf, $dataNascimento, $enderecoId, $usuarioId);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM pacientes");
        $pacientes = [];
        while ($data = $result->fetch_assoc()) {
            $pacientes[] = new Paciente((int)$data['id'], $data['nome'], $data['cpf'], $data['data_nascimento'], (int)$data['endereco_id'], (int)$data['usuario_id']);
        }
        return $pacientes;
    }

    public function buscarPorId(int $id): ?Paciente{
        $sql = "SELECT * FROM pacientes WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Paciente((int)$row['id'], $row['nome'], $row['cpf'], $row['data_nascimento'], (int)$row['endereco_id'], (int)$row['usuario_id']);
        }
        return null;
    }
    public function buscarPorUsuarioId(int $usuarioId): ?Paciente {
        $sql = "SELECT * FROM pacientes WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Paciente((int)$row['id'], $row['nome'], $row['cpf'], $row['data_nascimento'], (int)$row['endereco_id'], (int)$row['usuario_id']);
        }
        return null;
    }

    public function editar(Paciente $paciente): bool{
        $id = $paciente->getId();
        $nome = $paciente->getNome();
        $cpf = $paciente->getCpf();
        $dataNascimento = $paciente->getDataNascimento();
        $enderecoId = $paciente->getEnderecoId();
        $usuarioId = $paciente->getUsuarioId();
        $sql = "UPDATE pacientes SET nome = ?, cpf = ?, data_nascimento = ?, endereco_id = ?, usuario_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssiii", $nome, $cpf, $dataNascimento, $enderecoId, $usuarioId, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM pacientes WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}