<?php
class Cliente {
    public int $id;
    public string $nombre_comercial;
    public string $rut;
    public string $direccion;
    public string $categoria;
    public string $contacto_nombre;
    public string $contacto_email;
    public string $porcentaje_descuento;



    public function __construct(array $data) {
        $this->id = $data['id'] ?? 0;
        $this->nombre_comercial = $data['nombre_comercial'] ?? '';
        $this->rut = $data['rut'] ?? '';
        $this->direccion = $data['direccion'] ?? '';
        $this->categoria = $data['categoria'] ?? '';
        $this->contacto_nombre = $data['contacto_nombre'] ?? '';
        $this->contacto_email = $data['contacto_email'] ?? '';
        $this->porcentaje_descuento = $data['porcentaje_descuento'] ?? '';
    }
}