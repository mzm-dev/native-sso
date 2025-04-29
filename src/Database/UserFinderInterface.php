<?php

namespace Mzm\PhpSso\Database;

interface UserFinderInterface
{
    public function getLocalUser(array $userData): ?array;
    public function findLocalUser(array $userData): ?array;
    public function createInstantUser(array $userData): ?array;
}
