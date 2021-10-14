<?php

use Kavinsky\TacviewAcmiReader\Acmi;
use Kavinsky\TacviewAcmiReader\Parser\AcmiParser;
use Kavinsky\TacviewAcmiReader\Reader\AcmiTextReader;

it('test parser', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.txt.acmi');

    $reader = new AcmiTextReader();
    $parser = new AcmiParser($reader);

    $acmi = $parser->parseFromFile($acmiTxtPath);


    expect($acmi)->toBeInstanceOf(Acmi::class);
    expect($acmi->version)->not->toBeNull();
    expect($acmi->title)->not->toBeNull();
    expect($acmi->referenceLongitude)->toBeFloat()->not->toBeNull();
    expect($acmi->referenceLatitude)->toBeFloat()->not->toBeNull();
    expect($acmi->referenceTime)->toBeInstanceOf(\DateTimeInterface::class)->not->toBeNull();
    expect($acmi->recordingTime)->toBeInstanceOf(\DateTimeInterface::class)->not->toBeNull();

    dump($acmi->objects->first()->properties);
});
