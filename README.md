# WhatsApp for Laravel

[PT-BR]
Este pacote adiciona o uso do whatsapp com Laravel. 
É um wrapper que se utiliza da api provida pela lib 
[@tiagoandrepro/baileys-api](https://github.com/tiagoandrepro/baileys-api), 
que simplifica o uso da lib [@adiwajshing/Baileys](https://github.com/adiwajshing/Baileys).

## Instalação

```shell
composer require rocketslab/wa-laravel
```

O service provider é registrado automáticamente no Laravel.

```shell
php artisan wa:install
```

O comando acima instala as dependências de javascript incluindo
as libs mencionadas na introdução.

Opcionalmente você pode publicar o arquivo de configuração:

```shell
php artisan vendor:publish --provider=RocketsLab\\WALaravel\\WALaravelServiceProvider
```

Como esse pacote é fortemente dependente de websockets, tem
incluído junto a lib [@beyondcode/laravel-websockets](https://github.com/beyondcode/laravel-websockets).

## Iniciando os serviços

Será necessário inciar ambos servidores de **websocket** e a própria lib
**baileys-api**

Por padrão o servidor de websocket escuta a porta **6001**.
Pode-se utilizar outra porta e outras configurações do websocket,
tudo isto está descrito na documentação do beyondcode/laravel-websockets.
A configuração do websocket deve ser realizada como descrito na
sua documentação.

Inciando o servidor de websocket:

```shell
php artisan websocket:serve
```

O próximo passo é iniciar o servidor do baileys-api.

```shell
php artisan wa:serve
```

Por padrão o servidor da API do WA, inicia a comunicação
em localhost na porta 3333. Estas configurações podem ser
alteradas no arquivo de configuração em `config/wa-laravel`.

## Funcionamento

O funcionamento deste wrapper ocorre disparando eventos para sua 
aplicação notificando via **WebHooks** o que ocorreu no WhatsApp.

O pacote contém já um **EventSubscriber** e um **EventDispatcher** 
para lidar com os eventos gerados, mas se você quiser ter maior 
controle sobre estes eventos, pode desativar o registro automático
dos eventos alterando o parâmetro `register_events` no arquivo de
configuração `config/walaravel.php` para **false**.

### Lado do servidor

Criando uma nova sessão:

```php
    /* Com o servidor da API iniciado...
    // O segundo parâmetro é opcional. E informa a API
    */ que é uma versão legada do WA 
      
    $wa = \RocketsLab\WALaravel\WhatsApp::factory();
    /* Recomenda-se remover a sessão existente */
    $wa->removeSession('session-id');   
    $wa->start('session-id', false);
```

O retorno dos métodos é um `Http/Response` provido pelo cliente `Http`
do Laravel.

Para enviar mensagens:

```php
// No arquivo de rotas
Route::post('sendMessage', funciton(Request $request) {
    /* Pode-se extrair somente o necessário da requisição */
    $data = $request->only(['receiver', 'message', 'sessionId']);
    
    \RocketsLab\WALaravel\WhatsApp::factory()
        ->sendText(...$data);
})
```

### Lado cliente (Laravel Echo)

Configure o Laravel Echo conforme a [documentação](https://laravel.com/docs/9.x/broadcasting#client-side-installation).

Os hooks enviados pela API chegam na forma de requisições POST para
o servidor, esse pacote já tem estas rotas pré configuradas e para
cada hook recebido é disparado um evento do lado do servidor, e este
evento é feito um broadcast com os dados recebidos pelo evento.

Para que o cliente/browser possa receber estes eventos e processar
a informação, precisa-se escutar um canal específico em `walaravel.{id-da-sessão}`.

Os eventos que podem ser escutados no momento são:

| Evento           | Descrição                                                |
|------------------|----------------------------------------------------------|
| .connection-open | Ocorre quando uma sessão foi estabelecida com sucesso.   |
| .connection-closed | Ocorre quando a conexão foi interrompida (logout).       |
| .connection-connecting | Ocorre quando se lê o QRCode e inicia-se a autenticação. |
| .connnection-qrcode | Ocorre quando um QRCode é gerado para ser lido.          |
| .connection-updated | Ocorre quando há alguma atualização na conexão (WIP). |
| .message-upsert | Ocorre quando há novas atualizações em mensagens e notificações. |

#### Segue um pequeno exemplo:

Alterações no arquivo de layout (app.blade.php)...

> No head do layout precisamos remover o link para o `app.js` e passar
> esse link para o final do body do layout.

```html
<head>
    ....
    <!-- remover essa linha -->
    <link rel="stylesheet" href="{{ asset('js/app.js') }}" defer>
</head>
<body>
    ...
    <!-- incluir ela aqui no final -->
    <link rel="stylesheet" href="{{ asset('js/app.js') }}">
    @stack('scripts')
</body>
```

Carregando a view...

> Na rota que carrega a view pode-se passar um atributo `$sessionId`
> para identificar a sessão que vai receber os eventos, dessa forma
> se outro evento de outra sessão for enviado esse será descartado.

```php
Route::get('whatsapp-config', function() { 
   
   $sessionId = 'my-session';
   return view('wa-config', compact('sessionId')); 

});
```

Colocando o Echo para escutar os eventos da sessão `my-session`...

> Em alguma view blade coloque o bloco @push ao final. 
> O `$sessionId` aqui do exemplo é recebida como retorno ao
> carregar a view, pode ser estático ou vindo de um banco de dados. 

```php
<!-- VIEW: wa-config -->

@push('scripts') 
    <script>
        Echo.channel('{{ ".meesage-upsert.{$sessionId}" }}') 
            .listen('.message-upsert', ({ event }) => {
                console.log("MU: " + JSON.stringify(event))
            });
    </script>
@endpush
```

**Continua...**

----

*Esta documentação está em WIP, assim como este pacote.*

Qualquer dúvida ou sugestão por favor contate-nos via:

[oi@rocketslab.com.br](oi@rocketslab.com.br)

Criado por [jjsquady](https://github.com/jjsquady)

Colaborador [tiagoandre](https://github.com/tiagoandrepro)

@2022 RocketsLab
