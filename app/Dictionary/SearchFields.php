<?php

namespace App\Dictionary;

interface SearchFields
{
    public const FIELDS_ALL = 'a';
    public const FIELD_CLIENT = 'c';
    public const FIELD_PRODUCT = 'p';
    public const FIELD_TOTAL = 't';
    public const FIELD_DATE = 'd';

    public const FIELDS = [
        self::FIELD_CLIENT, self::FIELD_DATE, self::FIELD_PRODUCT, self::FIELD_TOTAL, self::FIELDS_ALL
    ];
}
