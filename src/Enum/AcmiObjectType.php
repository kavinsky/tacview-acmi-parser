<?php

namespace Kavinsky\TacviewAcmiParser\Enum;

use InvalidArgumentException;
use MabeEnum\Enum;

/**
 * @psalm-immutable
 * @method static AIR()
 * @method static GROUND()
 * @method static SEA()
 * @method static WEAPON()
 * @method static SENSOR()
 * @method static NAVAID()
 * @method static STATIC()
 * @method static HEAVY()
 * @method static MEDIUM()
 * @method static LIGHT()
 * @method static MINOR()
 * @method static FIXED_WING()
 * @method static ROTORCRAFT()
 * @method static ARMOR()
 * @method static ANTI_AIRCRAFT()
 * @method static WATERCRAFT()
 * @method static HUMAN()
 * @method static BIOLOGIC()
 * @method static MISSILE()
 * @method static ROCKET()
 * @method static BOMB()
 * @method static TORPEDO()
 * @method static PROJECTILE()
 * @method static BEAM()
 * @method static DECOY()
 * @method static BUILDING()
 * @method static BULLSEYE()
 * @method static WAYPOINT()
 * @method static TANK()
 * @method static WARSHIP()
 * @method static AIRCRAFT_CARRIER()
 * @method static SUBMARINE()
 * @method static INFANTRY()
 * @method static PARACHUTIST()
 * @method static SHELL()
 * @method static BULLET()
 * @method static FLARE()
 * @method static CHAFF()
 * @method static SMOKE_GRENADE()
 * @method static AERODROME()
 * @method static CONTAINER()
 * @method static SHRAPNEL()
 * @method static EXPLOSION()
 */
final class AcmiObjectType extends Enum
{
    public const AIR = 'Air';
    public const GROUND = 'Ground';
    public const SEA = 'Sea';
    public const WEAPON = 'Weapon';
    public const SENSOR = 'Sensor';
    public const NAVAID = 'Navaid';

    public const STATIC = 'Static';
    public const HEAVY = 'Heavy';
    public const MEDIUM = 'Medium';
    public const LIGHT = 'Light';
    public const MINOR = 'Minor';

    public const FIXED_WING = 'FixedWing';
    public const ROTORCRAFT = 'Rotorcraft';
    public const ARMOR = 'Armor';
    public const ANTI_AIRCRAFT = 'AntiAircraft';
    public const WATERCRAFT = 'Watercraft';
    public const HUMAN = 'Human';
    public const BIOLOGIC = 'Biologic';
    public const MISSILE = 'Missile';
    public const ROCKET = 'Rocket';
    public const BOMB = 'Bomb';
    public const TORPEDO = 'Torpedo';
    public const PROJECTILE = 'Projectile';
    public const BEAM = 'Beam';
    public const DECOY = 'Decoy';
    public const BUILDING = 'Building';
    public const BULLSEYE = 'Bullseye';
    public const WAYPOINT = 'Waypoint';

    public const TANK = 'Tank';
    public const WARSHIP = 'Warship';
    public const AIRCRAFT_CARRIER = 'AircraftCarrier';
    public const SUBMARINE = 'Submarine';
    public const INFANTRY = 'Infantry';
    public const PARACHUTIST = 'Parachutist';
    public const SHELL = 'Shell';
    public const BULLET = 'Bullet';
    public const FLARE = 'Flare';
    public const CHAFF = 'Chaff';
    public const SMOKE_GRENADE = 'SmokeGrenade';
    public const AERODROME = 'Aerodrome';
    public const CONTAINER = 'Container';
    public const SHRAPNEL = 'Shrapnel';
    public const EXPLOSION = 'Explosion';

    /**
     * Parses a string with AcmiObjectType values, can be multiple separated by "+" character.
     *
     * @psalm-pure
     * @param  string  $str
     * @return array<AcmiObjectType>
     */
    public static function fromString(string $str): array
    {
        $arrStr = explode('+', $str);
        $return = [];

        foreach ($arrStr as $item) {
            try {
                $return[] = self::byValue(trim($item));
            } catch (InvalidArgumentException $e) {
            }
        }

        return $return;
    }

    /**
     * Returns the Object Types of Class Type category
     *
     * @see https://www.tacview.net/documentation/acmi/en/#:~:text=Tags-,Class,-Air
     * @codeCoverageIgnore
     * @return array
     */
    public static function classTypes(): array
    {
        return [
            AcmiObjectType::AIR(),
            AcmiObjectType::GROUND(),
            AcmiObjectType::SEA(),
            AcmiObjectType::WEAPON(),
            AcmiObjectType::SENSOR(),
            AcmiObjectType::NAVAID(),
        ];
    }

    /**
     * Returns the Object Types of Attribute Type category
     *
     * @see https://www.tacview.net/documentation/acmi/en/#:~:text=Misc-,Attributes,-Static
     * @codeCoverageIgnore
     * @return array<AcmiObjectType>
     */
    public static function attributeTypes(): array
    {
        return [
            AcmiObjectType::STATIC(),
            AcmiObjectType::HEAVY(),
            AcmiObjectType::MEDIUM(),
            AcmiObjectType::LIGHT(),
            AcmiObjectType::MINOR(),
        ];
    }

    /**
     * Returns the Object Types of Basic Type category
     *
     * @see https://www.tacview.net/documentation/acmi/en/#:~:text=Waypoint-,Specific%20Types,-Tank
     * @codeCoverageIgnore
     * @return array<AcmiObjectType>
     */
    public static function basicTypes(): array
    {
        return [
            AcmiObjectType::FIXED_WING(),
            AcmiObjectType::ROTORCRAFT(),
            AcmiObjectType::ARMOR(),
            AcmiObjectType::ANTI_AIRCRAFT(),
            AcmiObjectType::WATERCRAFT(),
            AcmiObjectType::HUMAN(),
            AcmiObjectType::BIOLOGIC(),
            AcmiObjectType::MISSILE(),
            AcmiObjectType::ROCKET(),
            AcmiObjectType::BOMB(),
            AcmiObjectType::TORPEDO(),
            AcmiObjectType::PROJECTILE(),
            AcmiObjectType::BEAM(),
            AcmiObjectType::DECOY(),
            AcmiObjectType::BUILDING(),
            AcmiObjectType::BULLSEYE(),
            AcmiObjectType::WAYPOINT(),
        ];
    }

    /**
     * Returns the Object Types of Specific Type category
     *
     *
     * @see https://www.tacview.net/documentation/acmi/en/#:~:text=Waypoint-,Specific%20Types,-Tank
     * @codeCoverageIgnore
     * @return array<AcmiObjectType>
     */
    public static function specificTypes(): array
    {
        return [
            AcmiObjectType::TANK(),
            AcmiObjectType::WARSHIP(),
            AcmiObjectType::AIRCRAFT_CARRIER(),
            AcmiObjectType::SUBMARINE(),
            AcmiObjectType::INFANTRY(),
            AcmiObjectType::PARACHUTIST(),
            AcmiObjectType::SHELL(),
            AcmiObjectType::BULLET(),
            AcmiObjectType::FLARE(),
            AcmiObjectType::CHAFF(),
            AcmiObjectType::SMOKE_GRENADE(),
            AcmiObjectType::AERODROME(),
            AcmiObjectType::CONTAINER(),
            AcmiObjectType::SHRAPNEL(),
            AcmiObjectType::EXPLOSION(),
        ];
    }
}
