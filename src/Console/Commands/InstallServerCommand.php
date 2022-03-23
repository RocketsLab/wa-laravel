<?php
namespace RocketsLab\WALaravel\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallServerCommand extends Command
{
    protected $signature = "wa:install";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install WA server dependencies.';

    public function handle()
    {
        $this->info("Updating server dependencies...");

        $packageArray = json_decode(file_get_contents(base_path('package.json')), true);

        if(!isset($packageArray['dependencies'])) {
            $packageArray = array_merge($packageArray, [
                'dependencies' => []
            ]);
        }

        if(isset($packageArray['dependencies']['baileys-api'])) {

            $this->comment("Dependency already added.");

        } else {
            $this->comment("Dependency 'baileys-api' added.");
            $packageArray['dependencies'] = array_merge($packageArray['dependencies'], [
                'baileys-api' => "github:tiagoandrepro/baileys-api"
            ]);

            $updatedJson = json_encode($packageArray, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            file_put_contents(base_path('package.json'), $updatedJson);
        }

        $this->info('Running npm install...');

        (new Process(['npm', 'install'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });

        $this->info("Done. Run php artisan wa:serve to start.");

    }
}
