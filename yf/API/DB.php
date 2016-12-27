<?php
//error_reporting(E_ALL);

/**
 * Class DataBase
 */
class DataBase{
    //  Here provide your information for MySQL connection
    private $db_host = "localhost";

    /**
     * @return string
     */
    public function getDbHost()
    {
        return $this->db_host;
    }

    /**
     * @param string $db_host
     */
    public function setDbHost($db_host)
    {
        $this->db_host = $db_host;
    }

    /**
     * @return string
     */
    public function getDbUser()
    {
        return $this->db_user;
    }

    /**
     * @param string $db_user
     */
    public function setDbUser($db_user)
    {
        $this->db_user = $db_user;
    }

    /**
     * @return string
     */
    public function getDbPass()
    {
        return $this->db_pass;
    }

    /**
     * @param string $db_pass
     */
    public function setDbPass($db_pass)
    {
        $this->db_pass = $db_pass;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->db_db;
    }

    /**
     * @param string $db_db
     */
    public function setDbName($db_db)
    {
        $this->db_db = $db_db;
    }

    private $link;
    private $m_LastSql  =   "";
    private $m_LastQuery;
    private $m_DebugErrors  = 1;
    public $is_new = 1;


    /**
     * Escape a string before sql request
     * @param $string -  input
     * @return string - output
     */
    public function real_escape_string($string)
    {
        $ret = "";
        try{
            $ret = mysqli_real_escape_string($this->link,$string);
        }
        catch(Exception $ex){

        }
        return $ret;
    }

    /**
     * DataBase constructor.
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     */
    public function __construct($host="localhost",$user="ecdb",$pass="",$db="ecdb")
    {

        $this->setDbHost($host);
        $this->setDbUser($user);
        $this->setDbPass($pass);
        $this->setDbName($db);

        $this->link = new mysqli($this->db_host, $this->db_user, $this->db_pass,$this->db_db);
        if(mysqli_connect_errno()){
            echo "CONSTRUCT ERROR:" . mysqli_error($this->link);
        }
        if (!$this->link){
            die('Could not connect: ' .
                mysqli_error($this->link) .
                "<br/>" .
                mysqli_errno($this->link) .
                "<br/><br/>");
        }

        mysqli_select_db($this->link,$this->db_db);
        if(mysqli_errno($this->link)){
            echo "CONSTRUCT ERROR:" . mysqli_error($this->link);
        }

        mysqli_set_charset($this->link,"utf8");
    }

    public function disableDebug(){
        $this->m_DebugErrors = 0;
    }

    /**
     * Destructor
     */
    public function __destruct(){
        mysqli_close($this->link);
    }

    /**
     * Performs a query on the database
     * @param The query string. $sql
     * @return Returns FALSE on failure. For successful SELECT, SHOW,
     * DESCRIBE or EXPLAIN queries mysqli_query() will return a mysqli_result
     * object. For other successful queries mysqli_query() will return TRUE.
     */
    public function query($sql){
        $this->m_LastSql = $sql;
        $ret =  mysqli_query($this->link, $this->m_LastSql);
        $this->m_LastQuery  = $ret;
        if($this->m_DebugErrors>0)
            $this->checkMysqlErrors();

        return $ret;
    }

    /**
     * Gets the number of rows in a result
     * @param Procedural style only $result
     * @return Returns number of rows in the result set.
     */
    public function num_rows($result){
        return $this->count($result);
    }

    /**
     * Gets the number of rows in a result
     * @param Procedural style only $result
     * @return Returns number of rows in the result set.
     */
    public function count($result){
        if($result == null){
            $result = $this->m_LastQuery;
        }
        return (int)@mysqli_num_rows($result);
    }

    /**
     *  Fetch a result row as an associative, a numeric array, or both
     * @param Procedural style only $result
     * @return Returns an array of strings that corresponds to the fetched row or NULL if there are no more rows in resultset.
     */
    public function fetch_array($result){
        return mysqli_fetch_array($result);
    }

    /**
     * Fetch a result row as an associative array
     * @param Procedural style only $result
     * @return Returns an associative array of strings representing the
     * fetched row in the result set, where each key in the array represents
     * the name of one of the result set's columns or NULL if there are
     * no more rows in resultset.
     */
    public function fetch_assoc($result){
        return mysqli_fetch_assoc($result);
    }

    /**
     * Returns a string description of the last error
     * @return A string that describes the error. An empty string if no error occurred.
     */
    public function error(){
        return mysqli_error($this->link);
    }

    /**
     * Returns the error code for the most recent function call
     * @return An error code value for the last call, if it failed. zero means no error occurred.
     */
    public function errno(){
        return mysqli_errno($this->link);
    }

    /**
     * @return int
     */
    public function affected_rows(){
        return mysqli_affected_rows($this->link);
    }
    
    public function data_seek($result,$offset = 0)
    {
        $ret = false;
        try{
            $ret = mysqli_data_seek($result, $offset);
        } catch (Exception $ex) {
        }
        return $ret;
    }

    /**
     * Returns the auto generated id used in the last query
     * @return The value of the AUTO_INCREMENT field that was updated by the
     * previous query. Returns zero if there was no previous query on the
     * connection or if the query did not update an AUTO_INCREMENT value.
     */
    public function insert_id(){
        return mysqli_insert_id($this->link);
    }

    public function checkMysqlErrors(){
        if($this->errno()>0 && $this->errno() != 1062){
            echo "SQL ERROR:[". $this->errno() . "]" . $this->error() . "<br/>";
            echo $this->m_LastSql . "<br/>";
        }
        return $this->errno();
    }

    /***
     * mysqli_result::free -- mysqli_free_result — Frees the memory associated with a result
     * @param $result No value is returned.
     */
    public function free_result($result){
        return mysqli_free_result($result);
    }

}

$db = new DataBase("localhost","{USER}","{PASSWORD}","finance");



