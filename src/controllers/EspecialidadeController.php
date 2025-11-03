<?php
namespace controllers;

use repositories\EspecialidadeRepository; use models\Especialidade;
class EspecialidadeController {
    private EspecialidadeRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new EspecialidadeRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $especialidade = $this->repository->buscarPorId($id);
        if ($especialidade) { echo json_encode($especialidade);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Especialidade não encontrada']);
        }
    }

    public function criar($dados) {
        $especialidade = new Especialidade(null, $dados['titulo'], $dados['descricao'], []);
        if ($this->repository->criar($especialidade)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Especialidade criada com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar especialidade']);
        }
    }

    public function editar($id, $dados) {
        $especialidade = new Especialidade($id, $dados['titulo'], $dados['descricao'], []);
        if ($this->repository->editar($especialidade)) {
            echo json_encode(['mensagem' => 'Especialidade atualizada com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar especialidade']);
        }
    }

    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Especialidade deletada com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar especialidade']);
        }
    }
}