<?php

use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\Parser\AcmiParser;
use Kavinsky\TacviewAcmiParser\Parser\AcmiParserFactory;
use Kavinsky\TacviewAcmiParser\Parser\Reader\AcmiTextReader;

it('test parser', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.txt.acmi');

    $reader = new AcmiTextReader();
    $parser = new AcmiParser($reader, AcmiParserFactory::defaultHandlers());

    $acmi = $parser->parseFromFile($acmiTxtPath);


    expect($acmi)->toBeInstanceOf(Acmi::class);
    expect($acmi->version)->not->toBeNull();
    expect($acmi->properties->title)->not->toBeNull();
    expect($acmi->properties->referenceLongitude)->toBeFloat()->not->toBeNull();
    expect($acmi->properties->referenceLatitude)->toBeFloat()->not->toBeNull();
    expect($acmi->properties->referenceTime)->toBeInstanceOf(\DateTimeInterface::class)->not->toBeNull();
    expect($acmi->properties->recordingTime)->toBeInstanceOf(\DateTimeInterface::class)->not->toBeNull();

    expect($acmi->log->count())->toBeGreaterThan(0);
    expect($acmi->objects->count())->toBeGreaterThan(0);
});
