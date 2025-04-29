<?php

namespace Mzm\PhpSso\Enums;

class Queries
{
    public const FIND_USER_QUERY = "
        SELECT tdirektori.*, egerak_unit.unit as nama_unit
        FROM tdirektori
        LEFT JOIN egerak_unit ON egerak_unit.kodunit = tdirektori.Unit
        WHERE %s
        LIMIT 1
    ";

    public const FIND_USER_WHERE = [
        'emel' => 'email' ?? null,
        'nokp' => 'nokp' ?? null,
        'status' => null, // force cari user active
    ];
}
