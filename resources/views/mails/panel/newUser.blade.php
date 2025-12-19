@component('mail::message')
# Cadastro com sucesso!

Seja bem-vindo(a) o {{ config('app.name') }}<br>
Seu cadastro foi realizado com sucesso na plataforma!

@component('mail::button', ['url' => route('panel.index')])
    Meu Painel
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
