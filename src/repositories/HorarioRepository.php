<?php

namespace repositories;
use models\Horario;

class HorarioRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Horario $horario): bool{
        $sql = "INSERT INTO horarios (hora_minuto) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $horaMinuto = $horario->getHoraMinuto();
        $stmt->bind_param("s", $horaMinuto);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM horarios");
        $horarios = [];
        while ($data = $result->fetch_assoc()) {
            $horarios[] = new Horario((int)$data['id'], $data['hora_minuto']);
        }
        return $horarios;
    }

    public function buscarPorId(int $id): ?Horario{
        $sql = "SELECT * FROM horarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Horario((int)$row['id'], $row['hora_minuto']);
        }
        return null;
    }

    public function editar(Horario $horario): bool{
        $id = $horario->getId();
        $horaMinuto = $horario->getHoraMinuto();
        $sql = "UPDATE horarios SET hora_minuto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $horaMinuto, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM horarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}