<?php

use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\Enum\AcmiDateFormat;
use Kavinsky\TacviewAcmiParser\Parser\Handlers\GlobalPropertyHandler;

it('matches and parses ReferenceTime', function () {
    $sentence = '0,ReferenceTime=1990-05-01T06:00:00Z';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->referenceTime)->not->toBeNull()
        ->toBeInstanceOf(\Carbon\CarbonInterface::class);

    $timestamp = \Carbon\Carbon::createFromFormat(
        AcmiDateFormat::NORMAL,
        '1990-05-01T06:00:00Z',
        'UTC'
    );
    expect($acmi->properties->referenceTime->timestamp)
        ->toBe($timestamp->timestamp);
});

it('matches and parses RecordingTime', function () {
    $sentence = '0,RecordingTime=2020-12-26T21:04:15.365Z';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->recordingTime)->not->toBeNull()
        ->toBeInstanceOf(\Carbon\CarbonInterface::class);

    $timestamp = \Carbon\Carbon::createFromFormat(
        AcmiDateFormat::EXTENDED,
        '2020-12-26T21:04:15.365Z',
        'UTC'
    );
    expect($acmi->properties->recordingTime->timestamp)
        ->toBe($timestamp->timestamp);
});

it('matches and parses Title', function () {
    $sentence = '0,Title=F-14B_IA_Caucasus_Free Flight';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->title)
        ->toBe('F-14B_IA_Caucasus_Free Flight');
});

it('matches and parses DataRecorder', function () {
    $sentence = '0,DataRecorder=DCS2ACMI 1.8.4.200';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->dataRecorder)
        ->toBe('DCS2ACMI 1.8.4.200');
});

it('matches and parses DataSource', function () {
    $sentence = '0,DataSource=DCS 2.5.6.59625';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->dataSource)
        ->toBe('DCS 2.5.6.59625');
});

it('matches and parses Author', function () {
    $sentence = '0,Author=Nuevo apodo';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->author)
        ->toBe('Nuevo apodo');
});

it('matches and parses Comments', function () {
    $sentence = '0,Comments=Sight-seeing in the black sea - best seat in the house!';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->comments)
        ->toBe('Sight-seeing in the black sea - best seat in the house!');
});

it('matches and parses ReferenceLongitude', function () {
    $sentence = '0,ReferenceLongitude=33';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->referenceLongitude)
        ->toBe(33.0);
});

it('matches and parses ReferenceLatitude', function () {
    $sentence = '0,ReferenceLatitude=39';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->referenceLatitude)
        ->toBe(39.0);
});

it('matches and parses Intercept', function () {
    $sentence = '0,Category=Intercept';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->category)
        ->toBe('Intercept');
});

it('matches and parses Debriefing', function () {
    $sentence = '0,Debriefing=USS Stennis\, Tacan 74 X\, ICLS Channel 1\, 225 AM\, BRC 128°\
Arco\, Viking Tanker\, 225 AM\, Tacan 33Y\, 14000 feet';
    $acmi = new Acmi();
    $delta = 0.0;

    $handler = new GlobalPropertyHandler();
    expect($handler->matches($sentence))->toBeTrue();

    $handler->handle($sentence, $acmi, $delta);

    expect($acmi->properties->debriefing)
        ->toBe('USS Stennis, Tacan 74 X, ICLS Channel 1, 225 AM, BRC 128°
Arco, Viking Tanker, 225 AM, Tacan 33Y, 14000 feet');
});
