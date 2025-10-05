<?php

namespace models;

enum StatusAgendamento: string {
    case MARCADO = 'MARCADO';
    case CANCELADO = 'CANCELADO';
    case REALIZADO = 'REALIZADO';
}