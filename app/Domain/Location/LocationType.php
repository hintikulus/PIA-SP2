<?php

namespace App\Domain\Location;

use App\Model\Exception\Logic\InvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Represents a Doctrine type for handling Location objects in the database.
 */
class LocationType extends Type
{
    const LOCATION = 'location';

    /**
     * Gets the SQL declaration for the location type.
     *
     * @param array $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The database platform.
     * @return string The SQL declaration for the location type.
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * Converts a value from the database to a Location object.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return Location|null The converted Location object, or null if the value is null.
     * @throws ConversionException If the value is not a string.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Location
    {
        if ($value === null) 
        {
            return null;
        }

        if (!is_string($value)) 
        {
            throw new ConversionException();
        }

        $values = explode(';', $value);
        return new Location($values[0], $values[1]);
    }

    /**
     * Converts a Location object to a value for storage in the database.
     *
     * @param mixed $value The Location object.
     * @param AbstractPlatform $platform The database platform.
     * @return string The converted value for storage in the database.
     * @throws InvalidArgumentException If the value is not a Location object.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!($value instanceof Location)) {
            throw new InvalidArgumentException('Not a valid type of Location instance');
        }

        return implode(';', [$value->getLatitude(), $value->getLongitude()]);
    }

    /**
     * Gets the name of the location type.
     *
     * @return string The name of the location type.
     */
    public function getName(): string
    {
        return self::LOCATION;
    }
}
