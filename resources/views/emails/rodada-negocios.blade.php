@component('mail::message')
Olá {{$nome}}!<br><br>
Meu nome é Aldir Baseggio Junior, sócio administrador da WEBContabilidade.com, nos encontramos na 2º edição da Rodada de Negócios e eu gostaria de dizer que foi um prazer imenso conhecer você e sua empresa.<br><br>
Gostaria de convidar você a conhecer melhor nossos serviços de contabilidade online, para isso basta acessar nosso site https://webcontabilidade.com e caso surja alguma dúvida ficaremos felizes em esclarecê-las.<br><br>
@component('mail::button', ['url' => 'https://webcontabilidade.com'])
Acesse nosso site
@endcomponent
Muito obrigado pela sua atenção e nós da WEBContabilidade desejamos sucesso em seus negócios ;)
@endcomponent