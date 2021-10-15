<?php

use Carbon\CarbonImmutable;
use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\AcmiEventRecord;
use Kavinsky\TacviewAcmiParser\Parser\Handlers\EventHandler;

it('matches the sentence', function () {
    $sentence = '0,Event=EventType|09090909090|Here is a random text';
    $acmi = new Acmi();
    $now = CarbonImmutable::now('UTC');
    $acmi->properties->referenceTime = $now->clone();
    $delta = 9.9;

    $handler = new EventHandler();

    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->log->count())
        ->toBeGreaterThan(0);

    /** @var AcmiEventRecord $event */
    expect($event = $acmi->log->first())
        ->not->toBeNull();

    expect($event->timestamp()->diffInMicroseconds($now->addMicroseconds(9900)))
        ->toBe(0);
});


it('not matches the sentence', function () {
    $sentence = '0,NotAnEvent=EventType|09090909090|Here is a random text';
    $handler = new EventHandler();

    expect($handler->matches($sentence))->toBeFalse();
});
