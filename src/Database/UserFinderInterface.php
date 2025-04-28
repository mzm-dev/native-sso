<?php

namespace Mzm\PhpSso\Database;

interface UserFinderInterface
{
    public function findLocalUser(array $userData): ?array;
}
