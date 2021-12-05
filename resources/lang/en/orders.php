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
        'dailyCheck' => 'Solo pedidos diarios',
        'filters'=> [
            'order' => ['all' => 'Pedidos (Todos)', 'pendiente' => 'Solo pendientes', 'recogido' => 'Recogidos', 'no_recogido' => 'No recogidos'],
            'payment' => ['all' => 'Pago (Todos)','sin_pagar' => 'Sin pagar', 'ya_pagado' => 'Pagado'],
        ],
    ],
    'userHistory' => [
        'title' => 'Historial de pedidos',
        'currentOrders' => 'Pendientes',
        'processedOrders' => 'Pedidos realizados',
        'noOrdersTitle' => 'No tienes pedidos realizados',
        'noOrdersAbout' => 'Tu historial de pedidos se mostrara aqui cuando realices una compra en la cantina',
        'modalCancelOrder' => 'Cancelar pedido',
        'modalBack' => 'Volver',
    ],
];
