<?php

namespace models;

class Medico {
    private ?int $id;
    private string $nome;
    private int $crm;
    private string $dataInscricao;
    private ?int $enderecoId;
    private int $usuarioId;

    public function __construct(?int $id = null, string $nome = '', int $crm = 0, string $dataInscricao = '', ?int $enderecoId = null, int $usuarioId = 0) {
        $this->id = $id;
        $this->nome = $nome;
        $this->crm = $crm;
        $this->dataInscricao = $dataInscricao;
        $this->enderecoId = $enderecoId;
        $this->usuarioId = $usuarioId;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getCrm(): int {
        return $this->crm;
    }

    public function setCrm(int $crm): void {
        $this->crm = $crm;
    }

    public function getDataInscricao(): string {
        return $this->dataInscricao;
    }

    public function setDataInscricao(string $dataInscricao): void {
        $this->dataInscricao = $dataInscricao;
    }

    public function getEnderecoId(): ?int {
        return $this->enderecoId;
    }

    public function setEnderecoId(?int $enderecoId): void {
        $this->enderecoId = $enderecoId;
    }

    public function getUsuarioId(): int {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $usuarioId): void {
        $this->usuarioId = $usuarioId;
    }
}