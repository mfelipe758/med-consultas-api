<?php

namespace models;

class Especialidade implements \JsonSerializable {
    private ?int $id;
    private string $titulo;
    private ?string $descricao;

    /**
     * @var int[]
     */
    private array $medicos;

    /**
     * @param int|null $id
     * @param string $titulo
     * @param string|null $descricao
     * @param int[] $medicos
     */
    public function __construct(?int $id, string $titulo, ?string $descricao, array $medicos)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->medicos = $medicos;
    }

    public function getMedicos(): array
    {
        return $this->medicos;
    }

    public function setMedicos(array $medicos): void
    {
        $this->medicos = $medicos;
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