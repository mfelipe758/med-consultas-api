<?php
namespace controllers;

use repositories\PacienteRepository; use models\Paciente;
class PacienteController {
    private PacienteRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new PacienteRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $paciente = $this->repository->buscarPorId($id);
        if ($paciente) {
            echo json_encode($paciente);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Paciente não encontrado']);
        }
    }

    public function criar($dados) {
        $paciente = new Paciente(null, $dados['nome'], $dados['cpf'], $dados['dataNascimento'], $dados['enderecoId'], $dados['usuarioId']);
        if ($this->repository->criar($paciente)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Paciente criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar paciente']);
        }
    }

    public function editar($id, $dados) {
        $paciente = new Paciente($id, $dados['nome'], $dados['cpf'], $dados['dataNascimento'], $dados['enderecoId'], $dados['usuarioId']);
        if ($this->repository->editar($paciente)) {
            echo json_encode(['mensagem' => 'Paciente atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar paciente']);
        }
    }

    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Paciente deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar paciente']);
        }
    }
}