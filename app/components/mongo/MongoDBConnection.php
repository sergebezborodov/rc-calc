<?php

class MongoDBConnectionException extends AppException {}

/**
 * Подключение к mongo DB
 */
class MongoDBConnection extends CApplicationComponent
{
    /**
     * @var string сервер и порт
     */
    public $server = 'mongodb://localhost:27017';

    /**
     * @var string название базы
     */
    public $db;

    /**
     * @var MongoDb
     */
    protected $_db;

    /**
     * @var Mongo
     */
    protected $_connection;

    /**
     * @return MongoDb
     */
    public function getDb()
    {
        if ($this->_db == null) {
            if (!$this->db) {
                throw new MongoDBConnectionException('Не указано название БД');
            }

            $mongo = new Mongo($this->server);
            $this->_db = $mongo->selectDB($this->db);
        }
        return $this->_db;
    }

    /**
     * Закрытие соединения с базой
     */
    public function __destruct()
    {
        if ($this->_connection) {
            $this->_connection->close();
        }
    }
}
