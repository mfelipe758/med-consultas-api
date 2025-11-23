<?php

namespace repositories;
use models\Medico;

class MedicoRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Medico $medico): bool{
        $sql = "INSERT INTO medicos (nome, crm, data_inscricao, endereco_id, usuario_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $nome = $medico->getNome();
        $crm = $medico->getCrm();
        $dataInscricao = $medico->getDataInscricao();
        $enderecoId = $medico->getEnderecoId();
        $usuarioId = $medico->getUsuarioId();
        $stmt->bind_param("sisii", $nome, $crm, $dataInscricao, $enderecoId, $usuarioId);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM medicos");
        $medicos = [];
        while ($data = $result->fetch_assoc()) {
            $medicos[] = new Medico((int)$data['id'], $data['nome'], (int)$data['crm'], $data['data_inscricao'], (int)$data['endereco_id'], (int)$data['usuario_id']);
        }
        return $medicos;
    }

    public function buscarPorId(int $id): ?Medico{
        $sql = "SELECT * FROM medicos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Medico((int)$row['id'], $row['nome'], (int)$row['crm'], $row['data_inscricao'], (int)$row['endereco_id'], (int)$row['usuario_id']);
        }
        return null;
    }

    public function buscarPorUsuarioId(int $usuarioId): ?Medico {
        $sql = "SELECT * FROM medicos WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Medico((int)$row['id'], $row['nome'], (int)$row['crm'], $row['data_inscricao'], (int)$row['endereco_id'], (int)$row['usuario_id']);
        }
        return null;
    }

    public function buscarTitulosEspecialidades(int $medicoId): array {
        $sql = "SELECT e.titulo 
                FROM especialidades e
                JOIN medicos_tem_especialidades mte ON e.id = mte.id_especialidade
                WHERE mte.id_medico = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $medicoId);
        $stmt->execute();
        $result = $stmt->get_result();

        $titulos = [];
        while($row = $result->fetch_assoc()) {
            $titulos[] = $row['titulo'];
        }
        return $titulos;
    }

    public function vincularEspecialidades(int $medicoId, array $especialidadesIds): void {
        if (empty($especialidadesIds)) return;

        $sql = "INSERT INTO medicos_tem_especialidades (id_medico, id_especialidade) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);

        foreach ($especialidadesIds as $especialidadeId) {
            $idEsp = (int)$especialidadeId;
            $stmt->bind_param("ii", $medicoId, $idEsp);
            try {
                $stmt->execute();
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    public function editar(Medico $medico): bool{
        $id = $medico->getId();
        $nome = $medico->getNome();
        $crm = $medico->getCrm();
        $dataInscricao = $medico->getDataInscricao();
        $enderecoId = $medico->getEnderecoId();
        $usuarioId = $medico->getUsuarioId();
        $sql = "UPDATE medicos SET nome = ?, crm = ?, data_inscricao = ?, endereco_id = ?, usuario_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sisiii", $nome, $crm, $dataInscricao, $enderecoId, $usuarioId, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM medicos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}