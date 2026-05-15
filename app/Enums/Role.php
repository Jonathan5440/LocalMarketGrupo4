<?php

namespace App\Enums;

enum Role: string
{
    case Admin        = 'admin';
    case Comerciante  = 'comerciante';
    case Comprador    = 'comprador';
    case Repartidor   = 'repartidor';

    /**
     * Etiqueta legible para mostrar en UI.
     */
    public function label(): string
    {
        return match($this) {
            Role::Admin       => 'Administrador',
            Role::Comerciante => 'Comerciante',
            Role::Comprador   => 'Comprador',
            Role::Repartidor  => 'Repartidor',
        };
    }

    /**
     * Color de badge Tailwind para cada rol.
     */
    public function color(): string
    {
        return match($this) {
            Role::Admin       => 'bg-red-100 text-red-700',
            Role::Comerciante => 'bg-blue-100 text-blue-700',
            Role::Comprador   => 'bg-green-100 text-green-700',
            Role::Repartidor  => 'bg-orange-100 text-orange-700',
        };
    }
}
