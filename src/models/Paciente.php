<?php

namespace models;

use JsonSerializable;

class Paciente implements \JsonSerializable{
    private ?int $id;
    private string $nome;
    private string $cpf;
    private string $dataNascimento;
    private ?int $enderecoId;
    private int $usuarioId;
    /**
     * @var int[]
     */
    public array $agendamentos;

    public function __construct(?int $id = null, string $nome = '', string $cpf = '', string $dataNascimento = '', ?int $enderecoId = null, int $usuarioId = 0) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->enderecoId = $enderecoId;
        $this->usuarioId = $usuarioId;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'dataNascimento' => $this->dataNascimento,
            'enderecoId' => $this->enderecoId,
            'usuarioId' => $this->usuarioId
        ];
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

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }

    public function getDataNascimento(): string {
        return $this->dataNascimento;
    }

    public function setDataNascimento(string $dataNascimento): void {
        $this->dataNascimento = $dataNascimento;
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