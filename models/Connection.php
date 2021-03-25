<?php /** @noinspection PhpMissingFieldTypeInspection */


namespace App\Models;

use Exception;
use PDO;

abstract class Connection
{
    protected string $errorDetails;

    /**
     * @return PDO database connection
     */
    protected static function init(): PDO
    {
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        try {
            return new PDO("mysql:host={$_ENV["DB_HOST"]};port={$_ENV["DB_PORT"]};dbname={$_ENV["DB_NAME"]};charset=utf8", $_ENV["DB_USER"], $_ENV["DB_PASS"], $options);
        } catch (Exception $e) {
            die("Error connecting database - {$e->getMessage()}");
        }
    }

    /**
     * @return string|null return error string. If error not exist return null
     */
    public function getErrorDetails(): ?string
    {
        return $this->errorDetails;
    }

    public abstract function get(int $id): ?object;

    public abstract function list(string $search = null): ?array;

    public abstract function create($object): bool;

    public abstract function update($object): bool;

    public abstract function delete(int $id): bool;
}