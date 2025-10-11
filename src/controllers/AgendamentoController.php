<?php
namespace controllers;

use repositories\AgendamentoRepository;
use models\Agendamento;
use models\StatusAgendamento;
class AgendamentoController {
    private AgendamentoRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new AgendamentoRepository($conn);
    }
    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }
    public function buscarPorId($id) {
        $agendamento = $this->repository->buscarPorId($id);
        if ($agendamento) {
            echo json_encode($agendamento);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Agendamento não encontrado']);
        } }
    public function criar($dados) {
        $agendamento = new Agendamento(null, $dados['idPaciente'], $dados['idMedico'],
            $dados['idEspecialidade'], $dados['idHorario'], $dados['dataConsulta'],
            StatusAgendamento::from($dados['status']));
        if ($this->repository->criar($agendamento)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Agendamento criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar agendamento']);
        } }
    public function editar($id, $dados) {
        $agendamento = new Agendamento($id, $dados['idPaciente'], $dados['idMedico'],
            $dados['idEspecialidade'], $dados['idHorario'], $dados['dataConsulta'],
            StatusAgendamento::from($dados['status']));
        if ($this->repository->editar($agendamento)) {
            echo json_encode(['mensagem' => 'Agendamento atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar agendamento']);
        } }
    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Agendamento deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar agendamento']);
        } }
}