<?php
class Talla {
    public int $idTalla;
    public string $nombre;

    public function __construct(array $data) {
        $this->idTalla = $data['idTalla'] ?? 0;
        $this->nombre = $data['nombre'] ?? '';
    }
}