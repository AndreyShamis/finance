<?php
/**
 * Created by PhpStorm.
 * User: Andrey Shamis
 * Date: 8/11/14
 * Time: 9:09 PM
 */

class ExecutionTime {

    protected $m_StartTime      = 0;
    protected $m_End            = 0;
    protected $m_TimePrecision  = 3;

    public function __construct() {
        $this->m_StartTime = microtime(true);
    }

    public function getExecutionTime()
    {
        $this->CalculateExecutionTime();
        return round($this->m_End - $this->m_StartTime,$this->m_TimePrecision);
    }

    protected function CalculateExecutionTime()
    {
        $this->m_End = microtime(true);
    }
}