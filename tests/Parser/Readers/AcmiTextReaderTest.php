<?php

use Kavinsky\TacviewAcmiParser\Parser\Reader\AcmiTextReader;
use Kavinsky\TacviewAcmiParser\Parser\Reader\Exceptions\AccessErrorException;

it('it matches for .txt.acmi file format', function () {
    $acmiTxtPath = test_resource_path('line-join-test.txt.acmi');
    $reader = new AcmiTextReader();

    expect($reader->supports($acmiTxtPath))->toBeTrue();
});

it('can read complete sentence with split lines', function () {
    $acmiTxtPath = test_resource_path('line-join-test.txt.acmi');

    $reader = new AcmiTextReader();
    $reader->start($acmiTxtPath);

    $reader->nextSentence();
    $sentence = $reader->nextSentence();
    expect($sentence)->toBeString();
});

it('can multiple lines', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.txt.acmi');

    $reader = new AcmiTextReader();
    $reader->start($acmiTxtPath);

    expect($reader->nextSentence())->toBe("FileType=text/acmi/tacview");
    expect($reader->nextSentence())->toBe("FileVersion=2.2");
    expect($reader->nextSentence())->toBe("0,ReferenceTime=1990-05-01T06:00:00Z");
});

it('cant load invalid file path', function () {
    $acmiTxtPath = test_resource_path('simple-acmi.txt.acmi2');

    $reader = new AcmiTextReader();
    $reader->start($acmiTxtPath);
})->throws(AccessErrorException::class);

it('cant pass from eof', function () {
    $acmiTxtPath = test_resource_path('line-join-test.txt.acmi');

    $reader = new AcmiTextReader();
    $reader->start($acmiTxtPath);

    $reader->nextSentence();
    $reader->nextSentence();
    $reader->nextSentence();
    expect($reader->nextSentence())->toBeNull();
    expect($reader->eof())->toBeTrue();
});
