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

    /**
     * Running a transaction
     *
     * @param array $transaction Transaction query list
     *
     * Example:
     * [
     *     [
     *         'query' => 'INSERT INTO `table` SET `field1` = :field1, `field2` = :field2, `field3` = :field3',
     *         'data'  => [
     *             'field1' => 'val1',
     *             'field2' => 'val2',
     *             'field3' => 'val3',
     *         ],
     *     ], [
     *         'query' => 'UPDATE `table` SET `field1` = :field1 WHERE `field2` > :field2',
     *         'data'  => [
     *             'field1' => 'val1',
     *             'field2' => 'val2',
     *         ],
     *     ],
     * ]
     *
     * @return array|integer Returns the result of the request,
     * depending on the type of request
     *
     * @version v1.2.0 28.06.2016
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function transaction($transaction)
    {
        $this->connect();

        if (is_array($transaction) AND count($transaction) > 0) {
            try {
                $this->connect_id->beginTransaction();

                foreach ($transaction as $query_info) {
                    $STH = $this->connect_id->prepare($query_info['query']);
                    $STH->execute($query_info['data']);
                }

                $this->connect_id->commit();

                return [
                    'code'    => 'success',
                    'message' => 'The transaction completed successfully.',
                ];
            } catch (Exception $e) {
                $this->connect_id->rollBack();

                return [
                    'code'    => 'danger',
                    'message' => $e->getMessage(),
                ];
            }
        } else {
            return [
                'code'    => 'warning',
                'message' => 'In the transaction no queries.',
            ];
        }
    }
}
