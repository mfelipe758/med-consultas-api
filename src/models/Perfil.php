<?php

namespace models;

class Perfil implements \JsonSerializable {
    private ?PerfilTipo $id;
    private ?string $descricao;

    /**
     * @param PerfilTipo $id
     * @param string|null $descricao
     */
    public function __construct(PerfilTipo $id, ?string $descricao)
    {
        $this->id = $id;
        $this->descricao = $descricao;
    }

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    public function getId(): PerfilTipo
    {
        return $this->id;
    }

    public function setId(PerfilTipo $id): void
    {
        $this->id = $id;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): void
    {
        $this->descricao = $descricao;
    }


}