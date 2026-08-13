<?php

namespace Tests\Feature;

use Dompdf\Dompdf;
use Tests\TestCase;

class InvoicePdfFontTest extends TestCase
{
    public function test_dompdf_registers_myanmar_font_family(): void
    {
        $this->assertFileExists(storage_path('fonts/NotoSansMyanmar-Regular.ttf'));

        $dompdf = app(Dompdf::class);
        $families = array_change_key_case($dompdf->getFontMetrics()->getFontFamilies(), CASE_LOWER);

        $this->assertArrayHasKey('noto sans myanmar', $families);
    }
}
