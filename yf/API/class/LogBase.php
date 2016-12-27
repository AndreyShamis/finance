<?php
/**
 * Created by PhpStorm.
 * User: Andrey Shamis
 * Date: 8/11/14
 * Time: 8:43 PM
 */

class LogBase {

    protected $m_LogArray           = array();
    protected $m_WriteLogToBuffer   = 0;
    protected $m_LogPath            = "/tmp/LogBase.log";

    public function __construct($LogPath)
    {
        $this->SetLogPath($LogPath);
    }

    public function SetLogPath($newLogPath)
    {
        $this->m_LogPath = $newLogPath;
    }

    public function __destruct()
    {
        $this->Flush();
    }

    public function Flush()
    {
        if($this->m_WriteLogToBuffer == 1){
            foreach($this->m_LogArray as $key => $val){
                $this->WriteToFile($val);
            }
        }
    }

    public function AddToLog($value)
    {
        if($this->m_WriteLogToBuffer == 0){
            $this->WriteToFile($value);
        }
        else{
            array_push($this->m_LogArray,$value);
        }
    }

    protected function WriteToFile($msg)
    {
        error_log($msg . "\n" , 3, $this->m_LogPath);
    }

    public function WriteLogToBuffer($value=1)
    {
        $this->m_WriteLogToBuffer = ($value==1) ? 1 : 0;
        if($this->m_WriteLogToBuffer == 1){
            $this->Flush();
        }
    }
} 