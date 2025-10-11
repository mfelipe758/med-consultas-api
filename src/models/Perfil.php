<?php

namespace models;

class Perfil implements \JsonSerializable {
    private string $id;
    private ?string $descricao;

    public function __construct(string $id = '', ?string $descricao = null) {
        $this->id = $id;
        $this->descricao = $descricao;
    }
    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getDescricao(): ?string {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): void {
        $this->descricao = $descricao;
    }
}