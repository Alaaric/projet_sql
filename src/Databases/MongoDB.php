<?php

namespace App\Databases;

use MongoDB\Client;

class MongoDB
{
    private static $instance = null;
    private $client;
    private $databaseName;

    private function __construct()
    {
        $host = getenv('MONGO_HOST');
        $username = getenv('MONGO_INITDB_ROOT_USERNAME');
        $password = getenv('MONGO_INITDB_ROOT_PASSWORD');
        $this->databaseName = getenv('MONGO_INITDB_DATABASE');
       
        $uri = "mongodb://$username:$password@$host:27017";
        $this->client = new Client($uri);
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDatabase()
    {
        try {
            $database = $this->client->selectDatabase($this->databaseName);
        } catch (\Exception $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }

        return $database;
    }
    
    public function __clone()
    {
    }

    public function __wakeup()
    {
    }
}
