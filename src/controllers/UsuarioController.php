<?php
namespace controllers;

use repositories\UsuarioRepository;
use models\Usuario;

class UsuarioController {
    private UsuarioRepository $repository;

    public function __construct(\mysqli $conn) {
        $this->repository = new UsuarioRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $usuario = $this->repository->buscarPorId($id);
        if ($usuario) {
            echo json_encode($usuario);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Usuário não encontrado']);
        }
    }

    public function criar($dados) {
        $usuario = new Usuario(null, $dados['email'], $dados['senha'], $dados['ativo']);
        if ($this->repository->criar($usuario)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Usuário criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar usuário']);
        }
    }

    public function editar($id, $dados) {
        $usuario = new Usuario($id, $dados['email'], $dados['senha'], $dados['ativo']);
        if ($this->repository->editar($usuario)) {
            echo json_encode(['mensagem' => 'Usuário atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar usuário']);
        }
    }

    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Usuário deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar usuário']);
        }
    }
}