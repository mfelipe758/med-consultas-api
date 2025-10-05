-- Garante que estamos usando o banco de dados correto
USE medconsultas;

-- Apaga as tabelas na ordem inversa de dependência para evitar erros
DROP TABLE IF EXISTS consultas;
DROP TABLE IF EXISTS agendamentos;
DROP TABLE IF EXISTS medicos_tem_especialidades;
DROP TABLE IF EXISTS medicos;
DROP TABLE IF EXISTS especialidades;
DROP TABLE IF EXISTS pacientes;
DROP TABLE IF EXISTS enderecos;
DROP TABLE IF EXISTS usuarios_tem_perfis;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS perfis;
DROP TABLE IF EXISTS horarios;

-- =====================================================
-- CRIAÇÃO DAS TABELAS
-- =====================================================

CREATE TABLE perfis (
                        id VARCHAR(50) NOT NULL PRIMARY KEY,
                        descricao VARCHAR(255)
);

CREATE TABLE usuarios (
                          id BIGINT AUTO_INCREMENT PRIMARY KEY,
                          email VARCHAR(255) NOT NULL UNIQUE,
                          senha VARCHAR(255) NOT NULL,
                          ativo BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE usuarios_tem_perfis (
                                     usuario_id BIGINT NOT NULL,
                                     perfil_id VARCHAR(50) NOT NULL,
                                     PRIMARY KEY (usuario_id, perfil_id),
                                     FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
                                     FOREIGN KEY (perfil_id) REFERENCES perfis(id) ON DELETE CASCADE
);

CREATE TABLE enderecos (
                           id BIGINT AUTO_INCREMENT PRIMARY KEY,
                           cep VARCHAR(10),
                           estado VARCHAR(50),
                           cidade VARCHAR(100),
                           logradouro VARCHAR(255),
                           bairro VARCHAR(100),
                           numero VARCHAR(20),
                           complemento VARCHAR(100)
);

CREATE TABLE pacientes (
                           id BIGINT AUTO_INCREMENT PRIMARY KEY,
                           nome VARCHAR(255) NOT NULL,
                           cpf VARCHAR(14) NOT NULL UNIQUE,
                           data_nascimento DATE NOT NULL,
                           endereco_id BIGINT,
                           usuario_id BIGINT NOT NULL UNIQUE,
                           FOREIGN KEY (endereco_id) REFERENCES enderecos(id) ON DELETE SET NULL,
                           FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE especialidades (
                                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                                titulo VARCHAR(100) NOT NULL UNIQUE,
                                descricao TEXT
);

CREATE TABLE medicos (
                         id BIGINT AUTO_INCREMENT PRIMARY KEY,
                         nome VARCHAR(255) NOT NULL,
                         crm INT NOT NULL UNIQUE,
                         data_inscricao DATE NOT NULL,
                         endereco_id BIGINT,
                         usuario_id BIGINT NOT NULL UNIQUE,
                         FOREIGN KEY (endereco_id) REFERENCES enderecos(id) ON DELETE SET NULL,
                         FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE medicos_tem_especialidades (
                                            id_medico BIGINT NOT NULL,
                                            id_especialidade BIGINT NOT NULL,
                                            PRIMARY KEY (id_medico, id_especialidade),
                                            FOREIGN KEY (id_medico) REFERENCES medicos(id) ON DELETE CASCADE,
                                            FOREIGN KEY (id_especialidade) REFERENCES especialidades(id) ON DELETE CASCADE
);

CREATE TABLE horarios (
                          id BIGINT AUTO_INCREMENT PRIMARY KEY,
                          hora_minuto TIME NOT NULL
);

CREATE TABLE agendamentos (
                              id BIGINT AUTO_INCREMENT PRIMARY KEY,
                              id_paciente BIGINT NOT NULL,
                              id_medico BIGINT NOT NULL,
                              id_especialidade BIGINT NOT NULL,
                              id_horario BIGINT NOT NULL,
                              data_consulta DATE NOT NULL,
                              status ENUM('MARCADO', 'CANCELADO', 'REALIZADO') NOT NULL DEFAULT 'MARCADO',
                              FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE,
                              FOREIGN KEY (id_medico) REFERENCES medicos(id) ON DELETE CASCADE,
                              FOREIGN KEY (id_especialidade) REFERENCES especialidades(id) ON DELETE CASCADE,
                              FOREIGN KEY (id_horario) REFERENCES horarios(id) ON DELETE CASCADE,
                              UNIQUE (id_medico, data_consulta, id_horario)
);

CREATE TABLE consultas (
                           id BIGINT AUTO_INCREMENT PRIMARY KEY,
                           id_agendamento BIGINT NOT NULL UNIQUE,
                           data_hora_realizada DATETIME,
                           diagnostico TEXT,
                           observacoes TEXT,
                           receita TEXT,
                           FOREIGN KEY (id_agendamento) REFERENCES agendamentos(id) ON DELETE CASCADE
);

-- =====================================================
-- INSERÇÃO DE DADOS INICIAIS
-- =====================================================
INSERT INTO perfis (id, descricao) VALUES
                                       ('ADMIN', 'Administrador do sistema'),
                                       ('MEDICO', 'Profissional da saúde'),
                                       ('PACIENTE', 'Usuário paciente');