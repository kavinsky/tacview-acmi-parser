<?php


use Kavinsky\TacviewAcmiParser\Enum\AcmiObjectType;

it('test fromString', function () {
    $types = 'FixedWing+Rotorcraft';

    $return = AcmiObjectType::fromString($types);

    expect($return)->toBe([
        AcmiObjectType::FIXED_WING(),
        AcmiObjectType::ROTORCRAFT(),
    ]);
});

it('test fromString with spaces', function () {
    $types = 'FixedWing +  Rotorcraft';

    $return = AcmiObjectType::fromString($types);

    expect($return)->toBe([
        AcmiObjectType::FIXED_WING(),
        AcmiObjectType::ROTORCRAFT(),
    ]);
});


it('test fromString with invalid values', function () {
    $types = 'FixedWing+Rotorcraft+RamdomType';

    $return = AcmiObjectType::fromString($types);

    expect($return)->toBe([
        AcmiObjectType::FIXED_WING(),
        AcmiObjectType::ROTORCRAFT(),
    ]);
});
