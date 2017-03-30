<?php
class Database
{
  private static $dbName = '';
  private static $dbHost = 'localhost';
  private static $dbUsername = '';
  private static $dbUserPassword = '';

    private static $cont  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
          //self::$cont->exec("SET NAMES UTF8");\
          self::$cont->exec("utf8mb4");
        }
        catch(PDOException $e)
        {
          die($e->getMessage());
        }
       }
       return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
