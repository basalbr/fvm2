@component('mail::message')
# Solicitação de Abertura de Empresa
Olá {{$aberturaEmpresa->usuario->nome}}, recebemos sua solicitação de abertura de empresa.

@component('mail::button', ['url' => '$url'])
Visualizar processo
@endcomponent

A equipe da WEBContabilidade agradece sua preferência!
[![WEBContabilidade]({{url('images/logotipo-pequeno.png')}}]({{route('home')}})
@endcomponent