<?php
$routes = [
    // CAMISETAS
    '#^/camisetas$#-GET'                        => ['CamisetaController', 'index'],
    '#^/camisetas$#-POST'                       => ['CamisetaController', 'crear'],
    '#^/camisetas/ver$#-POST'                   => ['CamisetaController', 'ver'],
    '#^/camisetas$#-PUT'                        => ['CamisetaController', 'actualizar'],
    '#^/camisetas$#-PATCH'                      => ['CamisetaController', 'actualizarParcial'],
    '#^/camisetas$#-DELETE'                     => ['CamisetaController', 'eliminar'],

    // CLIENTES
    '#^/clientes$#-GET'                         => ['ClienteController', 'index'],
    '#^/clientes$#-POST'                        => ['ClienteController', 'crear'],
    '#^/clientes/ver$#-POST'                    => ['ClienteController', 'ver'],
    '#^/clientes$#-PUT'                         => ['ClienteController', 'actualizar'],
    '#^/clientes$#-PATCH'                       => ['ClienteController', 'actualizarParcial'],
    '#^/clientes$#-DELETE'                      => ['ClienteController', 'eliminar'],

    // TALLAS
    '#^/tallas$#-GET'                           => ['TallaController', 'index'],
    '#^/tallas$#-POST'                          => ['TallaController', 'crear'],
    '#^/tallas$#-PATCH'                         => ['TallaController', 'actualizar'],
    '#^/tallas$#-DELETE'                        => ['TallaController', 'eliminar'],

    '#^/camisetas/tallas$#-POST'                => ['TallaController', 'asignarTallas'],
    '#^/camisetas/tallas$#-DELETE'              => ['TallaController', 'eliminarTallas'],

    '#^/camisetas/precio$#-POST'                => ['CamisetaController', 'precioFinalCliente']
];
