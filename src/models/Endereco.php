<?php

namespace models;

class Endereco {
    private ?int $id;
    private ?string $cep;
    private ?string $estado;
    private ?string $cidade;
    private ?string $logradouro;
    private ?string $bairro;
    private ?string $numero;
    private ?string $complemento;

    public function __construct(?int $id = null, ?string $cep = null, ?string $estado = null, ?string $cidade = null, ?string $logradouro = null, ?string $bairro = null, ?string $numero = null, ?string $complemento = null) {
        $this->id = $id;
        $this->cep = $cep;
        $this->estado = $estado;
        $this->cidade = $cidade;
        $this->logradouro = $logradouro;
        $this->bairro = $bairro;
        $this->numero = $numero;
        $this->complemento = $complemento;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getCep(): ?string {
        return $this->cep;
    }

    public function setCep(?string $cep): void {
        $this->cep = $cep;
    }

    public function getEstado(): ?string {
        return $this->estado;
    }

    public function setEstado(?string $estado): void {
        $this->estado = $estado;
    }

    public function getCidade(): ?string {
        return $this->cidade;
    }

    public function setCidade(?string $cidade): void {
        $this->cidade = $cidade;
    }

    public function getLogradouro(): ?string {
        return $this->logradouro;
    }

    public function setLogradouro(?string $logradouro): void {
        $this->logradouro = $logradouro;
    }

    public function getBairro(): ?string {
        return $this->bairro;
    }

    public function setBairro(?string $bairro): void {
        $this->bairro = $bairro;
    }

    public function getNumero(): ?string {
        return $this->numero;
    }

    public function setNumero(?string $numero): void {
        $this->numero = $numero;
    }

    public function getComplemento(): ?string {
        return $this->complemento;
    }

    public function setComplemento(?string $complemento): void {
        $this->complemento = $complemento;
    }
}