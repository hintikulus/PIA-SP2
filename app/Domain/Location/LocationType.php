<?php

namespace App\Domain\Location;

use App\Model\Exception\Logic\InvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class LocationType extends Type
{
    const LOCATION = 'location';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Location
    {
        $values = explode(';', $value);
        return new Location($value[0], $value[1]);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if(!($value instanceof Location))
        {
            throw new InvalidArgumentException('Not valid type of location instance');
        }

        return implode(';', [$value->getLongitude(), $value->getLatitude()]);
    }

    public function getName()
    {
        return self::LOCATION;
    }
}