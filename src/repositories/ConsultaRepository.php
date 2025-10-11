<?php

namespace repositories;
use models\Consulta;

class ConsultaRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Consulta $consulta): bool{
        $sql = "INSERT INTO consultas (id_agendamento, data_hora_realizada, diagnostico, observacoes, receita) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $idAgendamento = $consulta->getIdAgendamento();
        $dataHoraRealizada = $consulta->getDataHoraRealizada();
        $diagnostico = $consulta->getDiagnostico();
        $observacoes = $consulta->getObservacoes();
        $receita = $consulta->getReceita();
        $stmt->bind_param("issss", $idAgendamento, $dataHoraRealizada, $diagnostico, $observacoes, $receita);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM consultas");
        $consultas = [];
        while ($data = $result->fetch_assoc()) {
            $consultas[] = new Consulta((int)$data['id'], (int)$data['id_agendamento'], $data['data_hora_realizada'], $data['diagnostico'], $data['observacoes'], $data['receita']);
        }
        return $consultas;
    }

    public function buscarPorId(int $id): ?Consulta{
        $sql = "SELECT * FROM consultas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Consulta((int)$row['id'], (int)$row['id_agendamento'], $row['data_hora_realizada'], $row['diagnostico'], $row['observacoes'], $row['receita']);
        }
        return null;
    }

    public function editar(Consulta $consulta): bool{
        $id = $consulta->getId();
        $idAgendamento = $consulta->getIdAgendamento();
        $dataHoraRealizada = $consulta->getDataHoraRealizada();
        $diagnostico = $consulta->getDiagnostico();
        $observacoes = $consulta->getObservacoes();
        $receita = $consulta->getReceita();
        $sql = "UPDATE consultas SET id_agendamento = ?, data_hora_realizada = ?, diagnostico = ?, observacoes = ?, receita = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issssi", $idAgendamento, $dataHoraRealizada, $diagnostico, $observacoes, $receita, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM consultas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}