<?php
namespace RocketsLab\WALaravel\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class StartServerCommand extends Command
{
    protected $signature = "wa:serve";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts WhatsApp server.';

    public function __construct()
    {
        parent::__construct();

        $this->specifyParameters();
    }

    protected function getOptions()
    {
        return array_merge([
            ['host', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.host')],
            ['port', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.port')],
            ['max-retries', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.max_retries')],
            ['reconnect-interval', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.reconnect_interval')],
            ['protocol', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.protocol')],
            ['ws-host', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.websocket.host')],
            ['ws-port', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.websocket.port')],
            ['ws-endpoint', null, InputOption::VALUE_OPTIONAL, '', config('walaravel.websocket.end_point')],
        ], parent::getOptions());
    }

    public function handle()
    {
        $host = $this->option("host");
        $port = $this->option("port");
        $maxRetries = $this->option("max-retries");
        $reconnectInterval = $this->option("reconnect-interval");
        $protocol = $this->option("protocol");
        $wsHost = $this->option("ws-host");
        $wsPort = $this->option("ws-port");
        $wsEndPoint = $this->option("ws-endpoint");

        $this->info("Starting whatsapp node server...");

        $serverPath = __DIR__ . "/../../../service/";

        (new Process(['node', 'server.mjs'], $serverPath, [
            'HOST' => $host,
            'PORT' => $port,
            'MAX_RETRIES' => $maxRetries,
            'RECONNECT_INTERVAL' => $reconnectInterval,
            'WS_HOST' => $wsHost,
            'WS_PORT' => $wsPort,
            'WS_ENDPOINT' => $wsEndPoint,
            'PROTOCOL' => $protocol,
        ]))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}
