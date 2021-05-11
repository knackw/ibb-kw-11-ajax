<?php

require_once "connect.php";

/**
 * Class Model
 */
abstract class Model
{
    protected ?Database $db;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $instance = Database::getInstance();
        $this->db = $instance;
    }
}

/**
 * Class Database
 * @package Core
 *
 * Klasse Datenbank
 *
 */
class Database
{

    private mysqli $connections;
    public mixed $last;
    public int $insertId;
    private static ?Database $instance = null;

    /**
     * @return Database|null
     *
     * Es wird nur eine Instance der Klasse erzeugt
     *
     */
    public static function getInstance(): ?Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Database constructor.
     */
    private function __construct()
    {
        $this->connections = new mysqli(SERVER, USERNAME, PASSWORD, DB);
        if (mysqli_connect_errno()) {
            trigger_error('Error connecting to host. ' . $this->connections->error, E_USER_ERROR);
        }
    }

    /**
     * @param $queryStr
     * @return bool
     *
     * Abfrage ausführen
     *
     */
    public function runQuery($queryStr): bool
    {
        if (!$result = $this->connections->query($queryStr)) {
            trigger_error('Fehler beim Ausführen der Abfrage: ' . $queryStr . ' -' . $this->connections->error, E_USER_ERROR);
        } else {
            $this->last = $result;
            $this->insertId = $this->connections->insert_id;
            return TRUE;
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->connections->close();
    }
}

/**
 * Class TableCreator
 *
 * Produktgenerator
 *
 */
class TableCreator extends Model
{

    private STRING $output="";

    /**
     * @return string
     *
     * Produkte generieren
     *
     */
    public function createProductTable(): string
    {
        $qrystring = "CREATE TABLE IF NOT EXISTS ibb_bilddatenbank (";
        $qrystring = $qrystring . "bildID INT(11) AUTO_INCREMENT, ";
        $qrystring = $qrystring . "bildUeberschrift VARCHAR(255), ";
        $qrystring = $qrystring . "bildFliesstext VARCHAR(255), ";
        $qrystring = $qrystring . "bildAutor VARCHAR(255), ";
        $qrystring = $qrystring . "bildKategorie VARCHAR(255), ";
        $qrystring = $qrystring . "bildDatum DATE, ";
        $qrystring = $qrystring . "bildStamp TIMESTAMP, ";
        $qrystring = $qrystring . "PRIMARY KEY(bildID))";

        if (!$this->db->runQuery($qrystring)) {
            $this->output .= '<strong>ERROR:</strong> An error occured while creating the Product Table';
        } else {
            $this->output .= '<strong>SUCCESS:</strong> <strong> Product Table </strong> was <strong> successfully </strong> created';
        }
        return $this->output;
    }
}

$tables_Creator = new TableCreator();
echo $tables_Creator->createProductTable();


