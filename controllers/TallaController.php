<?php
require 'utils.php';
require 'mapper/EntityMapper.php';
class TallaController
{
    public static function index(): void
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM tallas");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tallas = array_map('mapTalla', $rows);
        responderJSON($tallas);
    }

    public static function crear(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data['nombre'])) {
            responderJSON(['error' => 'Nombre requerido'], 400);
        }

        $stmt = $pdo->prepare("INSERT INTO tallas (nombre) VALUES (?)");
        $stmt->execute([$data['nombre']]);
        responderJSON(['mensaje' => 'Talla creada', 'id' => $pdo->lastInsertId()]);
    }

    public static function actualizar(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data['nombre'])) {
            responderJSON(['error' => 'Nombre requerido'], 400);
        }

        $stmt = $pdo->prepare("UPDATE tallas SET nombre = ? WHERE idTalla = ?");
        $stmt->execute([$data['nombre'], $data['idTalla']]);

        responderJSON(['mensaje' => 'Talla actualizada']);
    }

    public static function eliminar(): void
    {
        global $pdo;
        $data = getJSONInput();
        if (empty($data['idTalla'])) {
            responderJSON(['error' => 'Se debe ingresar un rut para consultar'], 400);
        }
        $stmt = $pdo->prepare("DELETE FROM tallas WHERE idTalla = ?");
        $stmt->execute([$data['idTalla']]);

        responderJSON(['mensaje' => 'Talla eliminada']);
    }

    public static function asignarTallas(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data['tallas']) || !is_array($data['tallas'])) {
            responderJSON(['error' => 'Se requiere una lista de tallas'], 400);
        }
        if (empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para asignar las tallas'], 400);
        }

        $stmt = $pdo->prepare("INSERT IGNORE INTO camiseta_talla (camiseta_id, talla_id) VALUES (?, ?)");
        foreach ($data['tallas'] as $idTalla) {
            $stmt->execute([$data['codProducto'], $idTalla]);
        }

        responderJSON(['mensaje' => 'Tallas asignadas']);
    }

    public static function eliminarTallas(): void
    {
        global $pdo;
        $data = getJSONInput();

        if (empty($data['tallas']) || !is_array($data['tallas'])) {
            responderJSON(['error' => 'Se requiere una lista de tallas a eliminar'], 400);
        }
        if (empty($data['codProducto'])) {
            responderJSON(['error' => 'Se debe ingresar un codigo de camiseta para eliminar las tallas'], 400);
        }

        $stmt = $pdo->prepare("DELETE FROM camiseta_talla WHERE camiseta_id = ? AND talla_id = ?");
        foreach ($data['tallas'] as $idTalla) {
            $stmt->execute([$data['codProducto'], $idTalla]);
        }

        responderJSON(['mensaje' => 'Tallas eliminadas de la camiseta']);
    }
}
