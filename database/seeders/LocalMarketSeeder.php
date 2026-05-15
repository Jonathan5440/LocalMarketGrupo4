<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Categoria;
use App\Models\Comercio;
use App\Models\InventarioMovimiento;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LocalMarketSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Administrador LocalMarket',
            'email'    => 'admin@localmarket.test',
            'password' => Hash::make('password'),
            'role'     => Role::Admin,
        ]);

        $categorias = collect([
            ['nombre' => 'Abarrotes', 'descripcion' => 'Productos básicos para el hogar.', 'icono' => '🛒'],
            ['nombre' => 'Panadería', 'descripcion' => 'Pan dulce, pan francés y repostería.', 'icono' => '🥐'],
            ['nombre' => 'Frutas y Verduras', 'descripcion' => 'Productos frescos del mercado.', 'icono' => '🥦'],
            ['nombre' => 'Carnes', 'descripcion' => 'Carnes frescas y embutidos.', 'icono' => '🥩'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Jugos, gaseosas y agua pura.', 'icono' => '🥤'],
        ])->map(fn ($categoria) => Categoria::create($categoria));

        $comerciosData = [
            [
                'user' => ['name' => 'Tienda La Bendición', 'email' => 'tienda@localmarket.test'],
                'comercio' => [
                    'nombre' => 'Tienda La Bendición',
                    'descripcion' => 'Tienda local con productos básicos para el hogar.',
                    'direccion' => 'Zona 1, Ciudad de Guatemala',
                    'telefono' => '5555-1001',
                    'email' => 'tienda@localmarket.test',
                    'activo' => true,
                ],
            ],
            [
                'user' => ['name' => 'Panadería San José', 'email' => 'panaderia@localmarket.test'],
                'comercio' => [
                    'nombre' => 'Panadería San José',
                    'descripcion' => 'Panadería artesanal con pan fresco todos los días.',
                    'direccion' => 'Zona 7, Ciudad de Guatemala',
                    'telefono' => '5555-1002',
                    'email' => 'panaderia@localmarket.test',
                    'activo' => true,
                ],
            ],
            [
                'user' => ['name' => 'Verduras El Mercado', 'email' => 'verduras@localmarket.test'],
                'comercio' => [
                    'nombre' => 'Verduras El Mercado',
                    'descripcion' => 'Venta de frutas y verduras frescas.',
                    'direccion' => 'Mixco, Guatemala',
                    'telefono' => '5555-1003',
                    'email' => 'verduras@localmarket.test',
                    'activo' => true,
                ],
            ],
        ];

        $comercios = collect();

        foreach ($comerciosData as $data) {
            $user = User::create([
                'name'     => $data['user']['name'],
                'email'    => $data['user']['email'],
                'password' => Hash::make('password'),
                'role'     => Role::Comerciante,
            ]);

            $comercios->push(Comercio::create([
                'user_id' => $user->id,
                ...$data['comercio'],
            ]));
        }

        $compradores = collect();

        for ($i = 1; $i <= 8; $i++) {
            $compradores->push(User::create([
                'name'     => "Comprador {$i}",
                'email'    => "comprador{$i}@localmarket.test",
                'password' => Hash::make('password'),
                'role'     => Role::Comprador,
            ]));
        }

        $productosData = [
            'Arroz Blanco', 'Frijol Negro', 'Azúcar Morena', 'Café Molido',
            'Pan Francés', 'Pan Dulce', 'Pastelito de Piña', 'Champurrada',
            'Tomate', 'Cebolla', 'Papa', 'Zanahoria',
            'Pollo Fresco', 'Carne Molida', 'Chorizo Artesanal',
            'Agua Pura', 'Jugo Natural', 'Gaseosa Familiar',
        ];

        $productos = collect();

        foreach ($productosData as $index => $nombre) {
            $productos->push(Producto::create([
                'comercio_id' => $comercios->random()->id,
                'categoria_id' => $categorias->random()->id,
                'nombre' => $nombre,
                'descripcion' => "Producto disponible en LocalMarket: {$nombre}.",
                'precio' => rand(500, 7500) / 100,
                'stock' => rand(2, 50),
                'imagen' => null,
                'activo' => true,
            ]));
        }

        for ($i = 1; $i <= 10; $i++) {
            $comercio = $comercios->random();
            $comprador = $compradores->random();

            $pedido = Pedido::create([
                'comprador_id' => $comprador->id,
                'comercio_id' => $comercio->id,
                'total' => 0,
                'estado' => collect(['pendiente', 'confirmado', 'en_camino', 'entregado', 'cancelado'])->random(),
                'direccion_entrega' => 'Dirección de entrega ejemplo #' . $i,
                'notas' => 'Pedido generado como dato de prueba.',
            ]);

            $productosPedido = $productos->where('comercio_id', $comercio->id)->take(2);

            $total = 0;

            foreach ($productosPedido as $producto) {
                $cantidad = rand(1, 3);
                $subtotal = $producto->precio * $cantidad;

                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $pedido->update([
                'total' => $total,
            ]);
        }

        foreach ($productos as $producto) {
            InventarioMovimiento::create([
                'producto_id' => $producto->id,
                'tipo' => 'entrada',
                'cantidad' => $producto->stock,
                'motivo' => 'Stock inicial',
                'user_id' => $admin->id,
            ]);
        }
    }
}
