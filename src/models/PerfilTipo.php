<?php

namespace models;

enum PerfilTipo: string {
    case ADMIN = 'ADMIN';
    case MEDICO = 'MEDICO';
    case PACIENTE = 'PACIENTE';
}