<?php
/**
* MySQL
*
* class to work with MySQL
*
* @version v1.1.0 05.05.2016
* @author Dmitrii Shcherbakov <atomcms@ya.ru>
*/

namespace DimNS\SimplePDO;

class MySQL extends AbstractPDO
{
    /**
    * @var string $host Database server
    */
    protected $host;

    /**
    * @var integer $port Server port
    */
    protected $port;

    /**
    * @var string $database Database name
    */
    protected $database;

    /**
    * @var string $user Username
    */
    protected $user;

    /**
    * @var string $password Password
    */
    protected $password;

    /**
    * Constructor
    *
    * @param string  $host   Database server
    * @param string  $dbname Database name
    * @param string  $user   Username
    * @param string  $pass   Password
    * @param integer $port   Port (3306 default)
    *
    * @return null
    *
    * @version v1.1.0 05.05.2016
    * @author Dmitrii Shcherbakov <atomcms@ya.ru>
    */
    public function __construct($host, $dbname, $user, $pass, $port = 3306)
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->database = $dbname;
        $this->user     = $user;
        $this->password = $pass;
    }

    /**
    * Database connection
    *
    * @return integer Database connection ID
    *
    * @version v1.1.0 05.05.2016
    * @author Dmitrii Shcherbakov <atomcms@ya.ru>
    */
    protected function connect()
    {
        if ($this->connect_id === null) {
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ];

            $this->connect_id = new \PDO(
                'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->database,
                $this->user,
                $this->password,
                $options
            );
        }

        return $this->connect_id;
    }
}
