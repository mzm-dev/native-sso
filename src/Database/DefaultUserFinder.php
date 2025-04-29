<?php

namespace Mzm\PhpSso\Database;

use Mzm\PhpSso\Enums\Queries;
use Mzm\PhpSso\Enums\Config;
use Mzm\PhpSso\Enums\Cons;
use Mzm\PhpSso\Helpers\DynamicConditionBuilder;
use Mzm\PhpSso\Helpers\Logger;

class DefaultUserFinder implements UserFinderInterface
{
    public $localhost;

    public $dbname;

    protected $username;

    protected $password;

    protected $userFinder;

    protected $database;

    protected $fields = [];

    public function __construct(array $config = [])
    {
        // Guna untuk akses Session Key
        $this->localhost = $config[Cons::CONN_HOST->value] ?? Config::CONN_HOST->value;
        $this->dbname = $config[Cons::CONN_DB->value] ?? Config::CONN_DB->value;
        $this->username = $config[Cons::CONN_USER->value] ?? Config::CONN_USER->value;
        $this->password = $config[Cons::CONN_PASS->value] ?? Config::CONN_PASS->value;

        try {
            $dsn = "mysql:host=" . $this->localhost . ";dbname=" . $this->dbname . ";charset=utf8mb4";
            $this->database = new \PDO($dsn, $this->username, $this->password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {
            die("ERROR: Could not connect. " . $e->getMessage());
        }
    }

    public function getLocalUser(array $userData): ?array
    {
        // 1. Mapping userData to searchFields      
        $searchFields = Queries::FIND_USER_WHERE;

        // 2. Build dynamic WHERE clause and Params
        list('where' => $whereClause, 'params' => $params) = DynamicConditionBuilder::build($searchFields, $userData);

        // 3. Construct the full SQL query by replacing %s with dynamic WHERE clause
        $sql = sprintf(Queries::FIND_USER_QUERY, $whereClause);

        // 4. Execute the query
        $stmt = $this->database->prepare($sql);

        if ($stmt->execute($params)) {
            Logger::log("Execute the query : " . json_encode($searchFields));
        } else {
            Logger::log($stmt->debugDumpParams());
        }


        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findLocalUser(array $userData): ?array
    {
        $user = $this->getLocalUser($userData);

        if (isset($userData['status']) && $user['Status'] == $userData['status'])
            return [];

        return $user ?: [];
    }

    public function createInstantUser(array $userData): ?array
    {
        return [];
    }
}
