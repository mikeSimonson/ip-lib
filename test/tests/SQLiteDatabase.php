<?php

namespace IPLib\Test;

use PDO;

abstract class SQLiteDatabase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO|null
     */
    private static $pdo = null;

    /**
     * @var PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection|null
     */
    private $connection = null;

    /**
     * {@inheritdoc}
     *
     * @see PHPUnit_Extensions_Database_TestCase::getConnection()
     */
    public function getConnection()
    {
        if ($this->connection === null) {
            if (self::$pdo == null) {
                $pdo = new PDO('sqlite::memory:');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $pdo->exec('
                    CREATE TABLE ranges (
                        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                        rangeRepresentation TEXT(44) NOT NULL,
                        addressType INTEGER NOT NULL,
                        rangeFrom TEXT(39) NOT NULL,
                        rangeTo TEXT(39) NOT NULL
                    )
                ');
                self::$pdo = $pdo;
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, ':memory:');
        }

        return $this->connection;
    }

    /**
     * {@inheritdoc}
     *
     * @see PHPUnit_Extensions_Database_TestCase::getDataSet()
     */
    public function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__.'/dataset.xml');
    }
}
