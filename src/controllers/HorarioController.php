<?php
namespace controllers;

use repositories\HorarioRepository; use models\Horario;
class HorarioController {
    private HorarioRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new HorarioRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $horario = $this->repository->buscarPorId($id);
        if ($horario) { echo json_encode($horario);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Horário não encontrado']);
        }
    }

    public function criar($dados) {
        $horario = new Horario(null, $dados['hora_minuto']);
        if ($this->repository->criar($horario)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Horário criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar horário']);
        }
    }

    public function editar($id, $dados) {
        $horario = new Horario($id, $dados['hora_minuto']);
        if ($this->repository->editar($horario)) {
            echo json_encode(['mensagem' => 'Horário atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar horário']);
        }
    }

    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Horário deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar horário']);
        }
    }
}