<?php

use Carbon\Carbon;
use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\AcmiEvent;
use Kavinsky\TacviewAcmiParser\Parser\Handlers\EventHandler;

it('matches the sentence', function () {
    $sentence = '0,Event=EventType|09090909090|Here is a random text';
    $acmi = new Acmi();
    $now = Carbon::now('UTC');
    $acmi->properties->referenceTime = $now->clone();
    $delta = 9.9;

    $handler = new EventHandler();

    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->events->count())
        ->toBeGreaterThan(0);

    /** @var AcmiEvent $event */
    expect($event = $acmi->events->first())
        ->not->toBeNull();

    expect($event->time->diffInMicroseconds($now->addMicroseconds(9900)))
        ->toBe(0);
});


it('not matches the sentence', function () {
    $sentence = '0,NotAnEvent=EventType|09090909090|Here is a random text';
    $handler = new EventHandler();

    expect($handler->matches($sentence))->toBeFalse();
});
