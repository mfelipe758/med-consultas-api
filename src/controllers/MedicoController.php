<?php
namespace controllers;

use repositories\MedicoRepository; use models\Medico;
class MedicoController {
    private MedicoRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new MedicoRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $medico = $this->repository->buscarPorId($id);
        if ($medico) { echo json_encode($medico);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Médico não encontrado']);
        }
    }

    public function criar($dados) {
        $medico = new Medico(null, $dados['nome'], $dados['crm'], $dados['dataInscricao'], $dados['enderecoId'], $dados['usuarioId']);
        if ($this->repository->criar($medico)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Médico criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar médico']);
        }
    }

    public function editar($id, $dados) {
        $medico = new Medico($id, $dados['nome'], $dados['crm'], $dados['dataInscricao'], $dados['enderecoId'], $dados['usuarioId']);
        if ($this->repository->editar($medico)) {
            echo json_encode(['mensagem' => 'Médico atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar médico']);
        }
    }

    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Médico deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar médico']);
        }
    }
}