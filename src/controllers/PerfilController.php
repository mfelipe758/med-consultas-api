<?php
namespace controllers;

use repositories\PerfilRepository;
class PerfilController {
    private PerfilRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new PerfilRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $perfil = $this->repository->buscarPorId($id);
        if ($perfil) { echo json_encode($perfil); }
        else {
            http_response_code(404);
            echo json_encode(['erro' => 'Perfil não encontrado']);
        }
    }
}