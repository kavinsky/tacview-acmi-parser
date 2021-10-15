<?php

use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\Parser\AcmiParserFactory;
use Kavinsky\TacviewAcmiParser\Parser\Handlers\SentenceHandlerInterface;
use Kavinsky\TacviewAcmiParser\Parser\Reader\AcmiZipReader;

it('uses default readers and handlers', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.zip.acmi');

    $factory = new AcmiParserFactory();

    $acmi = $factory->parse($acmiTxtPath);

    expect($acmi)->toBeInstanceOf(Acmi::class);
});

it('setReader', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.zip.acmi');

    $factory = new AcmiParserFactory();

    $factory->setReader(new AcmiZipReader());

    $acmi = $factory->parse($acmiTxtPath);


    expect($acmi)->toBeInstanceOf(Acmi::class);
});

it('addHandler', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.zip.acmi');

    $handlerMock = mock(SentenceHandlerInterface::class)->expect(
        matches: fn (string $name) => false
    );

    $factory = new AcmiParserFactory();
    $factory->addHandler($handlerMock);

    $acmi = $factory->parse($acmiTxtPath);


    expect($acmi)->toBeInstanceOf(Acmi::class);
});

it('setHandlers', function () {
    $acmiTxtPath = test_resource_path('line-join-test.zip.acmi');

    $handlerMock = mock(SentenceHandlerInterface::class)->expect(
        matches: fn (string $name) => false
    );

    $factory = new AcmiParserFactory();
    $factory->setHandlers($handlerMock);

    $acmi = $factory->parse($acmiTxtPath);


    expect($acmi)->toBeInstanceOf(Acmi::class);
});

it('throws exception if no readers available', function () {
    $acmiTxtPath = test_resource_path('line-join-test.invalid.acmi');

    $factory = new AcmiParserFactory();
    $factory->setReader([]);

    $acmi = $factory->parse($acmiTxtPath);
})->throws(\Exception::class);
