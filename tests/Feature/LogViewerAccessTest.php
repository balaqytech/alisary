<?php

use App\Models\User;

it('denies log viewer access to guests', function () {
    $this->get('/log-viewer')->assertForbidden();
});

it('allows authenticated users to view logs', function () {
    $this->actingAs(User::factory()->create())
        ->get('/log-viewer')
        ->assertSuccessful();
});
