<?php

namespace Tests\Feature;

use Tests\TestCase;

class MostRequestedReportTest extends TestCase
{
    public function test_report_validates_date_range(): void
    {
        $this->getJson('/api/v1/reports/most-requested?from=2026-11-20&to=2026-11-10')->assertUnprocessable();
    }
}
