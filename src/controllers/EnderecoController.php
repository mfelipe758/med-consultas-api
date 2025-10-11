<?php
namespace controllers;

use repositories\EnderecoRepository; use models\Endereco;
class EnderecoController {
    private EnderecoRepository $repository;
    public function __construct(\mysqli $conn) {
        $this->repository = new EnderecoRepository($conn);
    }

    public function buscarTodos() {
        echo json_encode($this->repository->buscarTodos());
    }

    public function buscarPorId($id) {
        $endereco = $this->repository->buscarPorId($id);
        if ($endereco) { echo json_encode($endereco);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Endereço não encontrado']);
        }
    }

    public function criar($dados) {
        $endereco = new Endereco(null, $dados['cep'], $dados['estado'], $dados['cidade'], $dados['logradouro'], $dados['bairro'], $dados['numero'], $dados['complemento']);
        if ($this->repository->criar($endereco)) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Endereço criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao criar endereço']);
        }
    }

    public function editar($id, $dados) {
        $endereco = new Endereco($id, $dados['cep'], $dados['estado'], $dados['cidade'], $dados['logradouro'], $dados['bairro'], $dados['numero'], $dados['complemento']);
        if ($this->repository->editar($endereco)) {
            echo json_encode(['mensagem' => 'Endereço atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao atualizar endereço']);
        }
    }
    public function deletar($id) {
        if ($this->repository->deletar($id)) {
            echo json_encode(['mensagem' => 'Endereço deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Falha ao deletar endereço']);
        }
    }
}