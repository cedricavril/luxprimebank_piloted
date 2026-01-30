<?php
class Database
{
    private static ?PDO $pdo = null;


    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $env = getenv('APP_ENV') ?: 'prod';
            $dbName = ($env === 'test') ? 'luxprime_test' : 'luxprime';

            try {
                self::$pdo = new PDO(
                    "mysql:unix_socket=/opt/lampp/var/mysql/mysql.sock;dbname=$dbName;charset=utf8mb4",
                    'root',
                    '',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die("Database connection failed ($dbName): " . $e->getMessage());
            }
        }

        return self::$pdo;
    }

  /** Reset PDO instance (useful for isolating tests) */
    public static function reset(): void
    {
        self::$pdo = null;
    }
    
}