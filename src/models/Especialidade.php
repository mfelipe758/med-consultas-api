<?php

namespace models;

class Especialidade implements \JsonSerializable {
    private ?int $id;
    private string $titulo;
    private ?string $descricao;

    public function __construct(?int $id = null, string $titulo = '', ?string $descricao = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
    }

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getDescricao(): ?string {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): void {
        $this->descricao = $descricao;
    }
}