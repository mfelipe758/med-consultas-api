<?php

namespace repositories;
use models\Agendamento;
use models\StatusAgendamento;

class AgendamentoRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Agendamento $agendamento): bool{
        $sql = "INSERT INTO agendamentos (id_paciente, id_medico, id_especialidade, id_horario, data_consulta, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $idPaciente = $agendamento->getIdPaciente();
        $idMedico = $agendamento->getIdMedico();
        $idEspecialidade = $agendamento->getIdEspecialidade();
        $idHorario = $agendamento->getIdHorario();
        $dataConsulta = $agendamento->getDataConsulta();
        $status = $agendamento->getStatus()->value;
        $stmt->bind_param("iiiiss", $idPaciente, $idMedico, $idEspecialidade, $idHorario, $dataConsulta, $status);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM agendamentos");
        $agendamentos = [];
        while ($data = $result->fetch_assoc()) {
            $agendamentos[] = new Agendamento((int)$data['id'], (int)$data['id_paciente'], (int)$data['id_medico'], (int)$data['id_especialidade'], (int)$data['id_horario'], $data['data_consulta'], StatusAgendamento::from($data['status']));
        }
        return $agendamentos;
    }

    public function buscarPorId(int $id): ?Agendamento{
        $sql = "SELECT * FROM agendamentos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Agendamento((int)$row['id'], (int)$row['id_paciente'], (int)$row['id_medico'], (int)$row['id_especialidade'], (int)$row['id_horario'], $row['data_consulta'], StatusAgendamento::from($row['status']));
        }
        return null;
    }

    public function editar(Agendamento $agendamento): bool{
        $id = $agendamento->getId();
        $idPaciente = $agendamento->getIdPaciente();
        $idMedico = $agendamento->getIdMedico();
        $idEspecialidade = $agendamento->getIdEspecialidade();
        $idHorario = $agendamento->getIdHorario();
        $dataConsulta = $agendamento->getDataConsulta();
        $status = $agendamento->getStatus()->value;
        $sql = "UPDATE agendamentos SET id_paciente = ?, id_medico = ?, id_especialidade = ?, id_horario = ?, data_consulta = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiiissi", $idPaciente, $idMedico, $idEspecialidade, $idHorario, $dataConsulta, $status, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM agendamentos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}