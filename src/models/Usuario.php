<?php

namespace models;

class Usuario implements \JsonSerializable{
    private ?int $id;
    private string $email;
    private string $senha;
    private bool $ativo;
    private ?Perfil $perfil;

    /**
     * @param int|null $id
     * @param string $email
     * @param bool $ativo
     * @param string $senha
     * @param Perfil $perfil
     */
    public function __construct(?int $id, string $email, string $senha, bool $ativo, Perfil $perfil)
    {
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
        $this->ativo = $ativo;
        $this->perfil = $perfil;
    }


    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'ativo' => $this->ativo
        ];
    }

    public function getPerfil(): Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(Perfil $perfil): void
    {
        $this->perfil = $perfil;
    }


    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    public function isAtivo(): bool {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): void {
        $this->ativo = $ativo;
    }
}