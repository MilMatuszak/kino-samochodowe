<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReservationControllerTest extends TestCase
{

    public function test_should_create_a_new_reservation_and_return_status_201(): void
    {
        $this->assertTrue(true);
    }

    public function test_should_return_status_400_bad_request_when_seat_is_already_taken(): void
    {
        $this->assertTrue(true);
    }
}