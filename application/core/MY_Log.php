<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        ExpressionEngine Dev Team
 * @copyright    Copyright (c) 2006, EllisLab, Inc.
 * @license        http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since        Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------
/**
 * MY_Logging Class
 *
 * This library assumes that you have a config item called
 * $config['show_in_log'] = array();
 * you can then create any error level you would like, using the following format
 * $config['show_in_log']= array('DEBUG','ERROR','INFO','SPECIAL','MY_ERROR_GROUP','ETC_GROUP'); 
 * Setting the array to empty will log all error messages. 
 * Deleting this config item entirely will default to the standard
 * error loggin threshold config item. 
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Logging
 * @author        ExpressionEngine Dev Team. Mod by Chris Newton
 */
class MY_Log extends CI_Log {
    /**
     * Constructor
     *
     * @access    public
     * @param    array the array of loggable items
     * @param    string    the log file path
     * @param     string     the error threshold
     * @param    string    the date formatting codes
     */
    function MY_Log()
    {
        parent::__construct();
        $config =& get_config();
        if (isset ($config['show_in_log']))
        {
            $show_in_log=$config['show_in_log'];
        }
        else
        {
            $show_in_log="";
        }
        $this->log_path = ($config['log_path'] != '') ? $config['log_path'] : BASEPATH.'logs/';
        
        if ( ! is_dir($this->log_path) OR ! is_really_writable($this->log_path))
        {
            $this->_enabled = FALSE;
        }
        if (is_array($show_in_log))
        {
            $this->_logging_array = $show_in_log;
        }
        if (is_numeric($config['log_threshold']))
        {
            $this->_threshold = $config['log_threshold'];
        }    
        if ($config['log_date_format'] != '')
        {
            $this->_date_fmt = $config['log_date_format'];
        }
    }
    // --------------------------------------------------------------------
    /**
     * Write Log File
     *
     * Generally this function will be called using the global log_message() function
     *
     * @access    public
     * @param    string    the error level
     * @param    string    the error message
     * @param    bool    whether the error is a native PHP error
     * @return    bool
     */        
    function write_log($level = 'debug', $msg)
    {        
        if ($this->_enabled === FALSE)
        {
            return FALSE;
        }
        $level = strtoupper($level);
        
        if (isset($this->_logging_array))
        {
            if ((! in_array($level, $this->_logging_array)) && (! empty($this->_logging_array)))
            {
                return FALSE;
            }
        }
        else 
        {
            if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
            {
                return FALSE;
            }
        }
		//New log file created in a week start
		 $date = strtotime(date('Y-m-d'));
		 //$date = strtotime(date('Y-m-d'));
		 $firstOfMonth = strtotime(date("Y-m-01", $date));
		 $weekOfMonth = intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
		 $logType = 'place';
		 if($level=='MY_INSTANCE')	
		 {
		 	$logType = 'admin';
		 }
		 else if($level=='MY_PLACE')
		 {
		 	$logType = 'place';
		 }
		//Code end
		 
        //$filepath = $this->log_path.'adminLog_'.date('Y-m-d').'.txt';
		$filepath = $this->log_path.$logType.'Logs_'.date('Y-m').'_'.$weekOfMonth.'.txt';
        $message  = '';
        
        if ( ! file_exists($filepath))
        {
           // $message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
        }
            
        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
        {
            return FALSE;
        }

        //$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' '.$msg."\n";
		$message .= date($this->_date_fmt). ' '.$msg;
        
        flock($fp, LOCK_EX);    
        fwrite($fp, $message."\r\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    
        @chmod($filepath, FILE_WRITE_MODE);         
        return TRUE;
    }

}