<?php
namespace controllers;

use repositories\ConsultaRepository; use models\Consulta;
class ConsultaController {
    private ConsultaRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new ConsultaRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $consulta = $this->repository->buscarPorId($id);
        if ($consulta) {
            echo json_encode($consulta);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Consulta não encontrada']);
        }
    }

    public function criar($dados) {
        $consulta = new Consulta(null, $dados['idAgendamento'], $dados['dataHoraRealizada'], $dados['diagnostico'], $dados['observacoes'], $dados['receita']);
        if ($this->repository->criar($consulta)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Consulta criada com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar consulta']);
        }
    }

    public function editar($id, $dados) {
        $consulta = new Consulta($id, $dados['idAgendamento'], $dados['dataHoraRealizada'], $dados['diagnostico'], $dados['observacoes'], $dados['receita']);
        if ($this->repository->editar($consulta)) {
            echo json_encode(['mensagem' => 'Consulta atualizada com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar consulta']);
        }
    }

    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Consulta deletada com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar consulta']);
        }
    }
}