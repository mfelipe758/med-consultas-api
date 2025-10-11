<?php

namespace repositories;
use models\Endereco;

class EnderecoRepository{
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
    }

    public function criar(Endereco $endereco): bool{
        $sql = "INSERT INTO enderecos (cep, estado, cidade, logradouro, bairro, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $cep = $endereco->getCep();
        $estado = $endereco->getEstado();
        $cidade = $endereco->getCidade();
        $logradouro = $endereco->getLogradouro();
        $bairro = $endereco->getBairro();
        $numero = $endereco->getNumero();
        $complemento = $endereco->getComplemento();
        $stmt->bind_param("sssssss", $cep, $estado, $cidade, $logradouro, $bairro, $numero, $complemento);
        return $stmt->execute();
    }

    public function buscarTodos(): array {
        $result = $this->conn->query("SELECT * FROM enderecos");
        $enderecos = [];
        while ($data = $result->fetch_assoc()) {
            $enderecos[] = new Endereco((int)$data['id'], $data['cep'], $data['estado'], $data['cidade'], $data['logradouro'], $data['bairro'], $data['numero'], $data['complemento']);
        }
        return $enderecos;
    }

    public function buscarPorId(int $id): ?Endereco{
        $sql = "SELECT * FROM enderecos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Endereco((int)$row['id'], $row['cep'], $row['estado'], $row['cidade'], $row['logradouro'], $row['bairro'], $row['numero'], $row['complemento']);
        }
        return null;
    }

    public function editar(Endereco $endereco): bool{
        $id = $endereco->getId();
        $cep = $endereco->getCep();
        $estado = $endereco->getEstado();
        $cidade = $endereco->getCidade();
        $logradouro = $endereco->getLogradouro();
        $bairro = $endereco->getBairro();
        $numero = $endereco->getNumero();
        $complemento = $endereco->getComplemento();
        $sql = "UPDATE enderecos SET cep = ?, estado = ?, cidade = ?, logradouro = ?, bairro = ?, numero = ?, complemento = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssi", $cep, $estado, $cidade, $logradouro, $bairro, $numero, $complemento, $id);
        return $stmt->execute();
    }

    public function deletar(int $id): bool{
        $sql = "DELETE FROM enderecos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}