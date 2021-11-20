<?php

return [
    'title' => [
        'index' => 'Listado pedidos',
    ],
    'create' => [
        'title' => 'Nuevo pedido'
    ],
    'edit' => [
        'title' => 'Editar pedido'
    ],
    'list' => [
        'order_status' => ['no_recogido' => 'No recogido', 'recogido' => 'Recogido', 'pendiente' => 'Pendiente'],
        'payment_status' => ['sin_pagar' => 'Sin pagar', 'ya_pagado' => 'Pagado'],
    ],
    'manage' => [
        'title' => 'Gestión de pedidos',
        'search' => 'Buscar pedido',
        'nodata' => 'Sin pedidos',
        'collected' => 'RECOGIDO',
        'cancel' => 'NO RECOGIDO',
        'report' => 'REPORTAR',
        'clientDataHeader' => 'Datos del cliente',
        'selectOrder' => 'Selecciona un pedido',
        'selectOrderDetailed' => ' Seleccione un pedido del listado para ver sus detalles y procesarlo',
        'filters'=> [
            'order' => ['all' => 'Todos', 'pendiente' => 'Solo pendientes', 'recogido' => 'Recogidos', 'no_recogido' => 'No recogidos'],
        ],
    ],
];
