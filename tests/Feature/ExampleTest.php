<?php

use function Pest\Laravel\get;

it('has welcome page', function () {
    get('/')->assertStatus(200);
});
