<?php
namespace controllers;

use repositories\UsuarioRepository;
use repositories\PacienteRepository;
use repositories\MedicoRepository;

class LoginController {
    private UsuarioRepository $repository;
    private PacienteRepository $pacienteRepository;
    private MedicoRepository $medicoRepository;

    public function __construct(\mysqli $conn) {
        $this->repository = new UsuarioRepository($conn);
        $this->pacienteRepository = new PacienteRepository($conn);
        $this->medicoRepository = new MedicoRepository($conn);
    }

    public function buscarTodos() {
        http_response_code(405);
        echo json_encode(['erro' => 'Método não permitido para login']);
    }

    public function buscarPorId($id) {
        $this->buscarTodos();
    }

    public function editar($id, $dados) {
        $this->buscarTodos();
    }

    public function deletar($id) {
        $this->buscarTodos();
    }

    public function criar($dados) {
        $email = trim($dados['email'] ?? '');
        $senha = $dados['senha'] ?? '';

        if (empty($email) || empty($senha)) {
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail e senha são obrigatórios.']);
            return;
        }

        $usuario = $this->repository->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario->getSenha())) {

            if (!$usuario->isAtivo()) {
                http_response_code(403);
                echo json_encode(['erro' => 'Usuário inativo. Contate o administrador.']);
                return;
            }
            $resposta = [
                'id' => $usuario->getId(),
                'email' => $usuario->getEmail(),
                'perfil' => $usuario->getPerfil()->getId()->value,
                'descricao' => $usuario->getPerfil()->getDescricao()
            ];
            if ($usuario->getPerfil()->getId()->value === 'PACIENTE') {
                $paciente = $this->pacienteRepository->buscarPorUsuarioId($usuario->getId());
                if ($paciente) {
                    $resposta['nome'] = $paciente->getNome();
                    $resposta['paciente_id'] = $paciente->getId();
                }
            }
            elseif ($usuario->getPerfil()->getId()->value === 'MEDICO') {
                $medico = $this->medicoRepository->buscarPorUsuarioId($usuario->getId());
                if ($medico) {
                    $resposta['nome'] = $medico->getNome();
                    $resposta['medico_id'] = $medico->getId();
                    $resposta['especialidades'] = $this->medicoRepository->buscarTitulosEspecialidades($medico->getId());
                }
            }

            http_response_code(200);
            echo json_encode([
                'mensagem' => 'Login realizado com sucesso',
                'usuario' => $resposta
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['erro' => 'E-mail ou senha inválidos.']);
        }
    }
}