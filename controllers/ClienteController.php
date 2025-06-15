<?php
require 'utils.php';
require 'mapper/EntityMapper.php';
class ClienteController
{
    public static function index(): void
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM clientes");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clientes = array_map('mapCliente', $rows);
        if($clientes)
            responderJSON($clientes);
        else
            responderJSON(['error' => 'No se encontraron clientes']);
    }

    public static function ver(): void
    {
        global $pdo;
        $data = getJSONInput();
        if(empty($data['rut'])) {
            responderJSON(['error' => 'Se debe ingresar un rut para consultar'], 400);
        }
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE rut = ?");
        $stmt->execute([$data['rut']]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $cliente = array_map('mapCliente', [$rows]);
        if ($cliente) {
            responderJSON($cliente[0]);
        } else {
            responderJSON(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public static function crear(): void
    {
        global $pdo;
        $data = getJSONInput();
        if(empty($data['rut'])) {
            responderJSON(['error' => 'Se debe ingresar un rut para crear cliente'], 400);
        }

        $campos = ['nombre_comercial', 'rut', 'direccion', 'categoria',
            'contacto_nombre', 'contacto_email', 'porcentaje_descuento'];
        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                responderJSON(['error' => "Campo requerido: $campo"], 400);
            }
        }

        $stmt = $pdo->prepare("INSERT INTO clientes (nombre_Comercial, rut, direccion, 
                      categoria, contacto_nombre, contacto_email, porcentaje_descuento)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $data['nombre_comercial'] ?? '',
            $data['rut'],
            $data['direccion'] ?? '',
            $data['categoria'] ?? 'Regular',
            $data['contacto_nombre'] ?? '',
            $data['contacto_email'] ?? '',
            $data['porcentaje_descuento'] ?? 0.0
        ]);

        responderJSON(['mensaje' => 'Cliente creado con éxito', 'id' => $pdo->lastInsertId()]);
    }

    public static function actualizar(): void
    {
        global $pdo;
        $data = getJSONInput();

        if(empty($data['rut'])) {
            responderJSON(['error' => 'Se debe ingresar un rut para actualizar cliente'], 400);
        }

        $stmt = $pdo->prepare("UPDATE clientes SET 
            nombre_comercial = ?, direccion = ?, categoria = ?, 
            contacto_nombre = ?, contacto_email = ?, porcentaje_descuento = ?
            WHERE rut = ?");

        $stmt->execute([
            $data['nombre_comercial'] ?? '',
            $data['direccion'] ?? '',
            $data['categoria'] ?? 'Regular',
            $data['contacto_nombre'] ?? '',
            $data['contacto_email'] ?? '',
            $data['porcentaje_descuento'] ?? 0.0,
            $data['rut']
        ]);

        responderJSON(['mensaje' => 'Cliente actualizado']);
    }

    public static function actualizarParcial(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data)) {
            responderJSON(['error' => 'No se enviaron datos para actualizar'], 400);
        }
        if(empty($data['rut'])) {
            responderJSON(['error' => 'Se debe ingresar un rut para actualizar cliente'], 400);
        }

        $camposPermitidos = [
            'nombre_comercial', 'direccion', 'categoria',
            'contacto_nombre', 'contacto_email', 'porcentaje_descuento'
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

        $params[] = $data['rut'];
        $sql = "UPDATE clientes SET " . implode(', ', $set) . " WHERE rut = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            responderJSON(['mensaje' => 'Cliente actualizado parcialmente']);
        } else {
            responderJSON(['mensaje' => 'Ningún cambio realizado o cliente no encontrado']);
        }
    }


    public static function eliminar(): void
    {
        global $pdo;
        $data = getJSONInput();
        if(empty($data['rut'])) {
            responderJSON(['error' => 'Se debe ingresar un rut para eliminar cliente'], 400);
        }

        $stmt = $pdo->prepare("DELETE FROM clientes WHERE rut = ?");
        $stmt->execute([$data['rut']]);

        if ($stmt->rowCount() > 0) {
            responderJSON(['mensaje' => 'Cliente eliminado']);
        } else {
            responderJSON(['error' => 'Cliente no encontrado'], 404);
        }
    }
}
