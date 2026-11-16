<?php

namespace Tests\Feature;

use App\Models\RentalLine;
use Tests\TestCase;

class OverdueBlockTest extends TestCase
{
    public function test_overdue_customer_is_blocked(): void
    {
        $this->operator();
        $u = $this->customer();
        $b = $this->bicycle(2);
        $r = $this->postJson('/api/v1/rentals', ['user_id' => $u->id, 'bicycle_ids' => [$b->id]])->json();
        RentalLine::find($r['lines'][0]['id'])->update(['due_at' => now()->subMinute()]);
        $this->postJson('/api/v1/rentals', ['user_id' => $u->id, 'bicycle_ids' => [$b->id]])->assertConflict()->assertJson(['code' => 'USER_HAS_OVERDUE_RENTALS']);
    }
}
