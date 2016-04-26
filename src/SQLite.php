<?php
/**
* SQLite
*
* class to work with SQLite
*
* @version v1.0.0 26.04.2016
* @author Dmitrii Shcherbakov <atomcms@ya.ru>
*/

namespace DimNS\SimplePDO;

class SQLite extends AbstractPDO
{
    /**
    * @var string $db_file Path to the file to the database
    */
    protected $db_file;

    /**
    * Constructor
    *
    * @param string $f Path to the file to the database
    *
    * @return null
    *
    * @version v1.0.0 26.04.2016
    * @author Dmitrii Shcherbakov <atomcms@ya.ru>
    */
    public function __construct($f)
    {
        $this->db_file = $f;
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
            ];

            $this->connect_id = new \PDO('sqlite:' . $this->db_file, null, null, $options);
        }

        return $this->connect_id;
    }
}
