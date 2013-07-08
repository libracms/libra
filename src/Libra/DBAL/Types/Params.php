<?php

namespace Libra\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Zend\Stdlib\Parameters;

/**
 * Params type save parameters as pretty json object.
 *
 * @author duke
 */
class Params extends Type
{
    const PARAMS = 'Libra\DBAL\Types\Params';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $valueArray = $value->toArray();

        return json_encode($valueArray, JSON_UNESCAPED_UNICODE);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return new Parameters();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;
        $valueArray = json_decode($value, true);

        return new Parameters($valueArray);
    }

    public function getName()
    {
        return self::PARAMS;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
