<?php

namespace models;

class Consulta {
    private ?int $id;
    private int $idAgendamento;
    private ?string $dataHoraRealizada;
    private ?string $diagnostico;
    private ?string $observacoes;
    private ?string $receita;

    public function __construct(?int $id = null, int $idAgendamento = 0, ?string $dataHoraRealizada = null, ?string $diagnostico = null, ?string $observacoes = null, ?string $receita = null) {
        $this->id = $id;
        $this->idAgendamento = $idAgendamento;
        $this->dataHoraRealizada = $dataHoraRealizada;
        $this->diagnostico = $diagnostico;
        $this->observacoes = $observacoes;
        $this->receita = $receita;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getIdAgendamento(): int {
        return $this->idAgendamento;
    }

    public function setIdAgendamento(int $idAgendamento): void {
        $this->idAgendamento = $idAgendamento;
    }

    public function getDataHoraRealizada(): ?string {
        return $this->dataHoraRealizada;
    }

    public function setDataHoraRealizada(?string $dataHoraRealizada): void {
        $this->dataHoraRealizada = $dataHoraRealizada;
    }

    public function getDiagnostico(): ?string {
        return $this->diagnostico;
    }

    public function setDiagnostico(?string $diagnostico): void {
        $this->diagnostico = $diagnostico;
    }

    public function getObservacoes(): ?string {
        return $this->observacoes;
    }

    public function setObservacoes(?string $observacoes): void {
        $this->observacoes = $observacoes;
    }

    public function getReceita(): ?string {
        return $this->receita;
    }

    public function setReceita(?string $receita): void {
        $this->receita = $receita;
    }
}