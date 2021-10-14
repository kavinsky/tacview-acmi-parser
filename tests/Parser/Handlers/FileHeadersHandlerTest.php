<?php

use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\Parser\Handlers\FileHeadersHandler;

it('matches the sentence FileType', function () {
    $sentence = 'FileType=text/acmi/tacview';
    $acmi = new Acmi();
    $delta = 0;

    $handler = new FileHeadersHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);
});

it('matches the sentence FileVersion', function () {
    $sentence = 'FileVersion=2.2';
    $acmi = new Acmi();
    $delta = 0;

    $handler = new FileHeadersHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);


    expect($acmi->version)->toBe('2.2');
});


it('not matches the sentence', function () {
    $sentence = '0,NotAnEvent=EventType|09090909090|Here is a random text';
    $handler = new FileHeadersHandler();

    expect($handler->matches($sentence))->toBeFalse();
});
