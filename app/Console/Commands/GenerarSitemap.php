<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class GenerarSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generar-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera el archivo sitemap.xml para mejorar el SEO de la web.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0))
            ->add(Url::create('/nosotros')
                ->setLastModificationDate(Carbon::now()->subDays(2))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7))
            ->add(Url::create('/contacto')
                ->setLastModificationDate(Carbon::now()->subDays(1))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6));

        // Ruta donde se guardará el sitemap
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ sitemap.xml generado correctamente en public/sitemap.xml');
    }
}
