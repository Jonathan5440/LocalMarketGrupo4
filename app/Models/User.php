<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => Role::class,   // cast automático al Enum
        ];
    }

    // ── Helpers de rol ────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    public function isComerciante(): bool
    {
        return $this->role === Role::Comerciante;
    }

    public function isComprador(): bool
    {
        return $this->role === Role::Comprador;
    }

    public function isRepartidor(): bool
    {
        return $this->role === Role::Repartidor;
    }

    public function hasRole(Role $role): bool
    {
        return $this->role === $role;
    }

    // ── Relaciones ────────────────────────────────────────────────────────────

    public function comercio(): HasOne
    {
        return $this->hasOne(Comercio::class);
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'comprador_id');
    }

    public function movimientosInventario(): HasMany
    {
        return $this->hasMany(InventarioMovimiento::class);
    }
}
