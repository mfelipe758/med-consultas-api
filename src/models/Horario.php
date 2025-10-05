<?php

namespace models;

class Horario {
    private ?int $id;
    private string $horaMinuto;

    public function __construct(?int $id = null, string $horaMinuto = '') {
        $this->id = $id;
        $this->horaMinuto = $horaMinuto;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getHoraMinuto(): string {
        return $this->horaMinuto;
    }

    public function setHoraMinuto(string $horaMinuto): void {
        $this->horaMinuto = $horaMinuto;
    }
}