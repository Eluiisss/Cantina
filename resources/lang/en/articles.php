<?php

return [
    'title' => [
        'index' => 'Listado de artículos',
        'trash' => 'Papelera de artículos',
    ],
    'create' => [
        'title' => 'Nuevos productos'
    ],
    'edit' => [
        'title' => 'Editar prodcuto'
    ],
    'forms' => [
        'status' => ['1' => 'Si', '0' => 'No']
    ],
    'filters' => [
        'stock' => ['all' => 'Stock','with'=>'Con stock', 'without' => 'Sin stock'],
        'allergy' => ['all' => 'Alérgenos','nonallergy' => 'Sin alérgenos', 'allergy' => 'Con alérgenos'],
        'veg' => ['all' => 'Vegetariano','veg' => 'Apto', 'nonveg' => 'No apto'],
    ]
];
