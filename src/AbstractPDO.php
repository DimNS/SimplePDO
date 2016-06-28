<?php
/**
 * AbstractPDO
 *
 * Abstract class
 *
 * @version v1.0.0 26.04.2016
 * @author Dmitrii Shcherbakov <atomcms@ya.ru>
 */

namespace DimNS\SimplePDO;

abstract class AbstractPDO
{
    /**
     * @var integer $connect_id Database connection ID
     */
    protected $connect_id = null;

    /**
     * Database connection
     *
     * @return integer Database connection ID
     *
     * @version v1.0.0 26.04.2016
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    abstract protected function connect();

    /**
     * Running a query
     *
     * @param string $query_str  Query (required)
     * @param array  $query_data Data (optional)
     *
     * @return array|integer Returns the result of the request,
     * depending on the type of request
     *
     * @version v1.0.0 26.04.2016
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function query($query_str, $query_data = [])
    {
        $this->connect();

        $query_type = mb_strtolower(mb_substr($query_str, 0, mb_strpos($query_str, ' ', 0, 'utf-8'), 'utf-8'), 'utf-8');

        switch ($query_type) {
            case 'select':
            case 'show':
                $STH = $this->connect_id->prepare($query_str);
                $STH->execute($query_data);
                return $STH->fetchAll();
                break;

            case 'insert':
                $STH = $this->connect_id->prepare($query_str);
                $STH->execute($query_data);
                return $this->connect_id->lastInsertId();
                break;

            case 'update':
            case 'delete':
            case 'create':
            case 'drop':
            case 'truncate':
            case 'rename':
            case 'alter':
                $STH = $this->connect_id->prepare($query_str);
                $STH->execute($query_data);
                return $STH->rowCount();
                break;

            default:
                return -1;
                break;
        }
    }
}
