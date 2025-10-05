<?php

namespace models;

require_once 'StatusAgendamento.php';

class Agendamento {
    private ?int $id;
    private int $idPaciente;
    private int $idMedico;
    private int $idEspecialidade;
    private int $idHorario;
    private string $dataConsulta;
    private StatusAgendamento $status;

    public function __construct(?int $id = null, int $idPaciente = 0, int $idMedico = 0, int $idEspecialidade = 0, int $idHorario = 0, string $dataConsulta = '', StatusAgendamento $status = StatusAgendamento::MARCADO) {
        $this->id = $id;
        $this->idPaciente = $idPaciente;
        $this->idMedico = $idMedico;
        $this->idEspecialidade = $idEspecialidade;
        $this->idHorario = $idHorario;
        $this->dataConsulta = $dataConsulta;
        $this->status = $status;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getIdPaciente(): int {
        return $this->idPaciente;
    }

    public function setIdPaciente(int $idPaciente): void {
        $this->idPaciente = $idPaciente;
    }

    public function getIdMedico(): int {
        return $this->idMedico;
    }

    public function setIdMedico(int $idMedico): void {
        $this->idMedico = $idMedico;
    }

    public function getIdEspecialidade(): int {
        return $this->idEspecialidade;
    }

    public function setIdEspecialidade(int $idEspecialidade): void {
        $this->idEspecialidade = $idEspecialidade;
    }

    public function getIdHorario(): int {
        return $this->idHorario;
    }

    public function setIdHorario(int $idHorario): void {
        $this->idHorario = $idHorario;
    }

    public function getDataConsulta(): string {
        return $this->dataConsulta;
    }

    public function setDataConsulta(string $dataConsulta): void {
        $this->dataConsulta = $dataConsulta;
    }

    public function getStatus(): StatusAgendamento {
        return $this->status;
    }

    public function setStatus(StatusAgendamento $status): void {
        $this->status = $status;
    }
}