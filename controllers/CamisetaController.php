<?php
require 'utils.php';
require 'mapper/EntityMapper.php';

class CamisetaController {
    public static function index(): void
    {
        global $pdo;
        $stmt = $pdo->query("SELECT codProducto, titulo, club, color, tipo, precio, pais, detalles, GROUP_CONCAT(t.nombre ORDER BY t.nombre SEPARATOR ', ') AS tallas
                                FROM camisetas c 
                                LEFT JOIN camiseta_talla ct ON c.codProducto = ct.camiseta_id
                                LEFT JOIN tallas t ON ct.talla_id = t.idTalla
                                GROUP BY titulo, club, color, tipo, precio, pais, detalles ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $camisetas = array_map('mapCamiseta', $rows);
        responderJSON($camisetas);
    }

    public static function ver(): void
    {
        global $pdo;
        $data = getJSONInput();

        if(empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para consultar'], 400);
        }
        $stmt = $pdo->prepare("SELECT codProducto, titulo, club, color, tipo, precio, pais, detalles, GROUP_CONCAT(t.nombre ORDER BY t.nombre SEPARATOR ', ') AS tallas 
                                FROM camisetas c 
                                LEFT JOIN camiseta_talla ct on c.codProducto = ct.camiseta_id 
                                LEFT JOIN tallas t on ct.talla_id = t.idTalla 
                                WHERE c.codProducto = ?");
        $stmt->execute([$data['codProducto']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $camiseta = array_map('mapCamiseta', [$row]);
        if ($camiseta) {
            responderJSON($camiseta[0]);
            return;
        }
        responderJSON(['error' => 'Camiseta no encontrada'], 404);
    }

    public static function crear(): void
    {
        global $pdo;
        $data = getJSONInput();
        if(empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para crear una nueva'], 400);
        }

        // Validaciones mínimas
        $campos = ['codProducto', 'titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'detalles'];
        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                responderJSON(['error' => "Campo requerido: $campo"], 400);
            }
        }

        $stmt = $pdo->prepare("INSERT INTO camisetas (codProducto, titulo, club, pais, tipo, color, precio, detalles) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['codProducto'], $data['titulo'], $data['club'], $data['pais'],
            $data['tipo'], $data['color'], $data['precio'], $data['detalles'] ?? ''
        ]);

        responderJSON(['mensaje' => 'Camiseta creada correctamente']);
    }

    public static function actualizar(): void
    {
        global $pdo;
        $data = getJSONInput();
        if(empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para actualizar'], 400);
        }

        $stmt = $pdo->prepare("UPDATE camisetas SET titulo=?, club=?, pais=?, tipo=?, color=?, precio=?, detalles=? WHERE codProducto=?");
        $stmt->execute([
            $data['titulo'], $data['club'], $data['pais'], $data['tipo'],
            $data['color'], $data['precio'], $data['detalles'] ?? '', $data['codProducto']
        ]);

        responderJSON(['mensaje' => 'Camiseta actualizada']);
    }

    public static function actualizarParcial(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data)) {
            responderJSON(['error' => 'No se enviaron datos para actualizar'], 400);
        }

        if(empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para actualizar'], 400);
        }

        $camposPermitidos = [
            'titulo', 'club', 'pais', 'categoria',
            'tipo', 'color', 'precio', 'detalles'
        ];

        $set = [];
        $params = [];

        foreach ($camposPermitidos as $campo) {
            if (array_key_exists($campo, $data)) {
                $set[] = "$campo = ?";
                $params[] = $data[$campo];
            }
        }

        if (empty($set)) {
            responderJSON(['error' => 'Ningún campo válido para actualizar'], 400);
        }

        $params[] = $data['codProducto'];
        $sql = "UPDATE camisetas SET " . implode(', ', $set) . " WHERE codProducto = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            responderJSON(['mensaje' => 'Camiseta actualizada parcialmente']);
        } else {
            responderJSON(['mensaje' => 'Ningún cambio realizado o camiseta no encontrada']);
        }
    }

    public static function eliminar(): void
    {
        global $pdo;
        $data = getJSONInput();
        if(empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para eliminar'], 400);
        }

        $stmt = $pdo->prepare("DELETE FROM camisetas WHERE codProducto = ?");
        $stmt->execute([$data['codProducto']]);
        responderJSON(['mensaje' => 'Camiseta eliminada']);
    }

    public static function precioFinalCliente(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data['rut'])) {
            responderJSON(['error' => 'Debe proporcionar un rut de cliente'], 400);
        }

        if(empty($data['codProducto'])) {
            responderJSON(['error' => 'Debe proporcionar un código de camiseta'], 400);
        }

        // Obtener la camiseta
        $stmt = $pdo->prepare("SELECT codProducto, titulo, precio FROM camisetas WHERE codProducto = ?");
        $stmt->execute([$data['codProducto']]);
        $camiseta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$camiseta) {
            responderJSON(['error' => 'Camiseta no encontrada'], 404);
        }

        // Obtener cliente
        $stmt = $pdo->prepare("SELECT porcentaje_descuento, nombre_comercial FROM clientes WHERE rut = ?");
        $stmt->execute([$data['rut']]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            responderJSON(['error' => 'Cliente no encontrado'], 404);
        }

        $precio = (float)$camiseta['precio'];
        $descuento = (float)$cliente['porcentaje_descuento'];
        $cliente = $cliente['nombre_comercial'];
        $precioFinal = round($precio * (1 - $descuento / 100), 0);

        $camiseta['cliente'] = $cliente;
        $camiseta['precio_final'] = $precioFinal;
        $camiseta['descuento_aplicado'] = $descuento;

        responderJSON($camiseta);
    }

}
