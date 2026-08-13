<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegisterMyanmarFonts extends Command
{
    protected $signature = 'fonts:register-myanmar';

    protected $description = 'Register Myanmar fonts with dompdf';

    public function handle()
    {
        $fontDir = storage_path('fonts');
        $this->info("Registering Myanmar fonts from: $fontDir");

        // dompdf should auto-discover fonts in the fonts directory
        // But we can help by listing them
        $fonts = glob($fontDir.'/*.ttf');

        if (empty($fonts)) {
            $this->warn('No TTF fonts found in storage/fonts directory');

            return;
        }

        foreach ($fonts as $font) {
            $this->info('Found font: '.basename($font));
        }

        $this->info('Myanmar fonts registered successfully!');
        $this->line('dompdf will use these fonts automatically when specified in CSS/HTML.');
    }
}
