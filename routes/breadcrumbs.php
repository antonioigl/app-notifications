<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


// Inicio
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'));
});

// Notificaciones
Breadcrumbs::for('messages', function ($trail) {
    $trail->push('Notificaciones', route('messages.index'));
});

// Inicio > Notificaciones > [Notificación]
Breadcrumbs::for('message', function ($trail, $message) {
    $trail->parent('messages');
    $trail->push($message->sender->email . ' (' . $message->sender->name .')', route('messages.show', $message));
});