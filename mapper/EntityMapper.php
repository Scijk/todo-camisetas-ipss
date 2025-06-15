<?php
require_once 'models/Camiseta.php';
require_once 'models/Cliente.php';
require_once 'models/Talla.php';

/**
 * Convierte una fila de camisetas (con tallas opcionales concatenadas) en una instancia de Camiseta
 */
function mapCamiseta(array $row): Camiseta
{
    return new Camiseta([
        'codProducto' => $row['codProducto'] ?? null,
        'titulo' => $row['titulo'] ?? null,
        'club' => $row['club'] ?? null,
        'color' => $row['color'] ?? null,
        'tipo' => $row['tipo'] ?? null,
        'precio' => $row['precio'] ?? null,
        'pais' => $row['pais'] ?? null,
        'detalles' => $row['detalles'] ?? null,
        'tallas' => isset($row['tallas']) ? explode(', ', $row['tallas']) : [],
    ]);
}

/**
 * Convierte una fila de clientes en una instancia de Cliente
 */
function mapCliente(array $row): Cliente
{
    return new Cliente([
        'id' => $row['id'] ?? null,
        'nombre_comercial' => $row['nombre_comercial'] ?? null,
        'rut' => $row['rut'] ?? null,
        'direccion' => $row['direccion'] ?? null,
        'categoria' => $row['categoria'] ?? null,
        'contacto_nombre' => $row['contacto_nombre'] ?? null,
        'contacto_email' => $row['contacto_email'] ?? null,
        'porcentaje_descuento' => $row['porcentaje_descuento'] ?? null
    ]);
}

/**
 * Convierte una fila de tallas en una instancia de Talla
 */
function mapTalla(array $row): Talla
{
    return new Talla([
        'idTalla' => $row['idTalla'] ?? null,
        'nombre' => $row['nombre'] ?? null,
    ]);
}
