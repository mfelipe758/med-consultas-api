<?php
namespace controllers;

use models\Perfil;
use models\PerfilTipo;
use models\Usuario;
use models\Paciente;
use models\Medico;
use repositories\PerfilRepository;
use repositories\UsuarioRepository;
use repositories\PacienteRepository;
use repositories\MedicoRepository;

class UsuarioController {
    private UsuarioRepository $repository;
    private PerfilRepository $perfilRepository;
    private PacienteRepository $pacienteRepository;
    private MedicoRepository $medicoRepository;
    private \mysqli $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
        $this->repository = new UsuarioRepository($conn);
        $this->perfilRepository = new PerfilRepository($conn);
        $this->pacienteRepository = new PacienteRepository($conn);
        $this->medicoRepository = new MedicoRepository($conn);
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

        if (empty($dados['email']) || empty($dados['senha']) || empty($dados['perfil_id'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados de login incompletos.']);
            return;
        }

        if ($this->repository->buscarPorEmail($dados['email'])) {
            http_response_code(409);
            echo json_encode(['erro' => 'E-mail já cadastrado.']);
            return;
        }

        $perfil = $this->perfilRepository->buscarPorId($dados['perfil_id']);
        if (!$perfil) { http_response_code(400);
            echo json_encode(['erro' => 'Perfil inválido']);
            return; }

        $this->conn->begin_transaction();

        try {
            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $usuario = new Usuario(null, $dados['email'], $senhaHash, (bool)($dados['ativo'] ?? true), $perfil);

            $novoUsuarioId = $this->repository->criar($usuario);

            if (!$novoUsuarioId) {
                throw new \Exception("Erro ao criar login do usuário.");
            }

            if ($perfil->getId()->value === 'PACIENTE') {
                if (empty($dados['nome']) || empty($dados['cpf']) || empty($dados['dataNascimento'])) {
                    throw new \Exception("Nome, CPF e Data de Nascimento são obrigatórios para Pacientes.");
                }

                $paciente = new Paciente(
                    null,
                    $dados['nome'],
                    $dados['cpf'],
                    $dados['dataNascimento'],
                    null,
                    $novoUsuarioId
                );

                if (!$this->pacienteRepository->criar($paciente)) {
                    throw new \Exception("Erro ao salvar dados do paciente.");
                }

            } elseif ($perfil->getId()->value === 'MEDICO') {
                if (empty($dados['nome']) || empty($dados['crm']) || empty($dados['dataInscricao'])) {
                    throw new \Exception("Nome, CRM e Data de Inscrição são obrigatórios para Médicos.");
                }

                $medico = new Medico(
                    null,
                    $dados['nome'],
                    (int)$dados['crm'],
                    $dados['dataInscricao'],
                    null,
                    $novoUsuarioId
                );

                if (!$this->medicoRepository->criar($medico)) {
                    throw new \Exception("Erro ao salvar dados do médico.");
                }
                $medicoCriado = $this->medicoRepository->buscarPorUsuarioId($novoUsuarioId);
                if ($medicoCriado && !empty($dados['especialidades']) && is_array($dados['especialidades'])) {
                    $this->medicoRepository->vincularEspecialidades($medicoCriado->getId(), $dados['especialidades']);
                }
            }

            $this->conn->commit();

            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Cadastro realizado com sucesso!',
                'usuario_id' => $novoUsuarioId,
                'tipo' => $perfil->getId()
            ]);

        } catch (\Exception $e) {
            $this->conn->rollback();
            http_response_code(400);
            echo json_encode(['erro' => $e->getMessage()]);
        }
    }

    public function editar($id, $dados) {
        $perfil = $this->perfilRepository->buscarPorId($dados['perfil_id']);
        if (!$perfil) {
            http_response_code(400);
            echo json_encode(['erro' => 'Perfil inválido']);
            return;
        }

        $usuario = new Usuario($id, $dados['email'], $dados['senha'], (bool)$dados['ativo'], $perfil);
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