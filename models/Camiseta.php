<?php
class Camiseta {
    public string $codProducto;
    public string $titulo;
    public string $club;
    public string $pais;
    public string $tipo;
    public string $color;
    public float $precio;
    public string $detalles;
    public array $tallas;

    public function __construct(array $data) {
        $this->codProducto = $data['codProducto'] ?? '';
        $this->titulo = $data['titulo'] ?? '';
        $this->club = $data['club'] ?? '';
        $this->pais = $data['pais'] ?? '';
        $this->tipo = $data['tipo'] ?? '';
        $this->color = $data['color'] ?? '';
        $this->precio = isset($data['precio']) ? (float)$data['precio'] : 0.0;
        $this->detalles = $data['detalles'] ?? '';
        $this->tallas = $data['tallas'] ?? [];
    }
}