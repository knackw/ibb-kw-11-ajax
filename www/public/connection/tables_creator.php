<?php

use mysqli;

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
 * Klasse Datenbank (Todo: in DAO umsetzen)
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
     * @return mixed
     *
     * Daten holen
     *
     */
    public function getData(): mixed
    {
        return $this->last->fetch_array(MYSQLI_ASSOC);
    }

    /**
     * @param $table
     * @param $condition
     * @param $limit
     *
     * Daten löschen
     *
     */
    public function deleteData($table, $condition, $limit)
    {
        $limit = ($limit == '') ? '' : ' LIMIT ' . $limit;
        $delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
        $this->runQuery($delete);
    }

    /**
     * @return mixed
     *
     * Anzahl der Datensätze
     *
     */
    public function numRows(): mixed
    {
        return $this->last->num_rows;
    }

    /**
     * @param $table
     * @param $changes
     * @param $condition
     * @return bool
     *
     * Datensatz aktualisieren
     *
     */
    public function updateData($table, $changes, $condition): bool
    {
        $update = "UPDATE " . $table . " SET ";
        foreach ($changes as $field => $value) {
            $update .= "`" . $field . "`='{$value}',";
        }

        $update = substr($update, 0, -1);
        if ($condition != '') {
            $update .= "WHERE " . $condition;
        }
        $this->runQuery($update);
        return true;
    }

    /**
     * @param $table
     * @param $data
     * @return bool
     *
     * Datensatz einfügen
     *
     */
    public function insertData($table, $data): bool
    {
        $fields = "";
        $values = "";
        foreach ($data as $f => $v) {
            $fields .= "`$f`,";
            $values .= (is_numeric($v) && (intval($v) == $v)) ?
                $v . "," : "'$v',";
        }
        $fields = substr($fields, 0, -1);

        $values = substr($values, 0, -1);
        $insert = "INSERT INTO $table ({$fields}) VALUES({$values})";
        return $this->runQuery($insert);
    }

    /**
     * @param $value
     * @return string
     *
     * Daten säubern
     *
     */
    public function cleanData($value): string
    {
        if ((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase')) != "off"))) {
            $value = stripslashes($value);
        }
        if (version_compare(phpversion(), "4.3.0") == "-1") {
            $value = $this->connections->escape_string($value);
        } else {
            $value = $this->connections->real_escape_string($value);
        }
        return $value;
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
     * Constructor
     */
    private function _constructor()
    {
        //silence is golden
    }

    /**
     * @return string
     *
     * Produkte generieren
     *
     */
    public function createProductTable(): string
    {
        if (!$this->db->runQuery("CREATE TABLE IF NOT EXISTS ibb_bilddatenbank
        (   bildID INT(11) AUTO_INCREMENT,
            bildUeberschrift VARCHAR(255),
            bildQuelle VARCHAR(255),
            bildFliesstext VARCHAR(255),
            bildAutor VARCHAR(255),
            bildKategorie VARCHAR(255),
            bildDatum DATE,
            bildStamp CURRENT_TIMESTAMP,
            PRIMARY KEY(bildID)
        ) ")) {
            $this->output .= '<strong>ERROR:</strong> An error occured while creating the Product Table';
        } else {
            $this->output .= '<strong>SUCCESS:</strong> <strong> Product Table </strong> was <strong> successfully </strong> created';
        }
        return $this->output;
    }
}

$tables_Creator = new TableCreator();
$tables_Creator->createProductTable();


