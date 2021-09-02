<?php

use App\Support\URL;

it('sanitizes url', function () {
    $url = URL::sanitize('https://github.com/vlasscontreras/php-trainer.git');
    expect($url)->toBe('https://github.com/vlasscontreras/php-trainer.git');

    $url = URL::sanitize('https://github.com/vlasscontreras/laravel-pest');
    expect($url)->toBe('https://github.com/vlasscontreras/laravel-pest');

    $url = URL::sanitize('gitlab.com/vlasscontreras/tests/pest.git'); // No protocol.
    expect($url)->toBe('');

    $url = URL::sanitize('vlasscontreras/tests/pest.git'); // No.
    expect($url)->toBe('');

    $url = URL::sanitize('not valid'); // Just, no.
    expect($url)->toBe('');
});

it('gets the proper path', function () {
    $url = URL::getPath('https://github.com/vlasscontreras/php-trainer.git');
    expect($url)->toBe('vlasscontreras/php-trainer');

    $url = URL::getPath('https://github.com/vlasscontreras/laravel-pest');
    expect($url)->toBe('vlasscontreras/laravel-pest');

    $url = URL::getPath('https://gitlab.com/vlasscontreras/tests/laravel.git');
    expect($url)->toBe('vlasscontreras/tests/laravel');

    $url = URL::getPath('gitlab.com/vlasscontreras/tests/pest.git'); // No protocol.
    expect($url)->toBe('');

    $url = URL::getPath('vlasscontreras/tests/pest.git'); // No TLD.
    expect($url)->toBe('');

    $url = URL::getPath('not valid'); // Again, no.
    expect($url)->toBe('');
});
