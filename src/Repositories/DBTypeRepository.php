<?php

namespace Vuongdq\VLAdminTool\Repositories;

/**
 * Class DBTypeRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:19 am UTC
 */
class DBTypeRepository {
    const MAPPING_CASTS = [
        "id" => 'integer',
        "increments" => 'integer',
        "integerIncrements" => 'integer',
        "tinyIncrements" => 'integer',
        "smallIncrements" => 'integer',
        "mediumIncrements" => 'integer',
        "bigIncrements" => 'integer',
        "char" => 'string',
        "string" => 'string',
        "text" => 'string',
        "mediumText" => 'string',
        "longText" => 'string',
        "integer" => 'integer',
        "tinyInteger" => 'integer',
        "smallInteger" => 'integer',
        "mediumInteger" => 'integer',
        "bigInteger" => 'integer',
        "unsignedInteger" => 'integer',
        "unsignedTinyInteger" => 'integer',
        "unsignedSmallInteger" => 'integer',
        "unsignedMediumInteger" => 'integer',
        "unsignedBigInteger" => 'integer',
        "float" => 'float',
        "double" => 'double',
        "decimal"  => 'decimal',
        "unsignedFloat"  => 'float',
        "unsignedDouble" => 'double',
        "unsignedDecimal"  => 'decimal',
        "boolean" => 'boolean',
        "json" => 'string',
        "date" => 'date',
        "dateTime" => 'datetime',
        "dateTimeTz" => 'datetime',
        "timestamp" => 'timestamp',
        "timestampTz" => 'timestamp',
        "softDeletes" => 'timestamp',
        "softDeletesTz" => 'timestamp',
    ];

    /**
     * @return string[]
     */
    public function getDBTypes() {
        return array_keys(self::MAPPING_CASTS);
    }

    public function getRuleByDBType(string $type) {
        return self::MAPPING_CASTS[$type];
    }
}
