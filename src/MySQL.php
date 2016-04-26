<?php
/**
* MySQL
*
* class to work with MySQL
*
* @version v1.0.0 26.04.2016
* @author Dmitrii Shcherbakov <atomcms@ya.ru>
*/

namespace DimNS\SimplePDO;

class MySQL extends AbstractPDO
{
    /**
    * @var integer $host Database server
    */
    protected $host;

    /**
    * @var integer $database Database name
    */
    protected $database;

    /**
    * @var integer $user Username
    */
    protected $user;

    /**
    * @var integer $password Password
    */
    protected $password;

    /**
    * Constructor
    *
    * @param string $h Database server
    * @param string $d Database name
    * @param string $u Username
    * @param string $p Password
    *
    * @return null
    *
    * @version v1.0.0 26.04.2016
    * @author Dmitrii Shcherbakov <atomcms@ya.ru>
    */
    public function __construct($h, $d, $u, $p)
    {
        $this->host     = $h;
        $this->database = $d;
        $this->user     = $u;
        $this->password = $p;
    }

    /**
    * Database connection
    *
    * @return integer Database connection ID
    *
    * @version v1.0.0 26.04.2016
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

            $this->connect_id = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->password, $options);
        }

        return $this->connect_id;
    }
}
