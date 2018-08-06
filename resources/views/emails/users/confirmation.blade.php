@component('mail::message')
# E-mail de bienvenida

Hola {{ $user->name  }}, bienvenido a {{ config('app.name') }}.

Debes confirmar tu correo electrónico haciendo clic en el siguiente botón:

@component('mail::button', ['url' =>  route('register.verify', $user->confirmation_code) ])
Confirmar email
@endcomponent

Si llegas a olvidar tu contraseña, la podrás recuperar a través de este correo.

Saludos,<br>
{{ config('app.name') }}


{{--Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
    @endcomponent
@endslot

@endcomponent
