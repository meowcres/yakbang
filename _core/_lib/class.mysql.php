<?php
class db
{
    var $host;
    var $user;
    var $pass;
    var $dbname;
    
    var $connect = 0;
    var $result  = 0;
    var $record  = array();
    var $row;
    var $Errno   = 0;
    var $Error   = '';
    
    
    function db()
    {
        $this->host   = '172.27.0.220';
        $this->user   = 'yakbang';
        $this->pass   = 'yakbang@)!*';
        $this->dbname = 'yakbang';
    }

    function db_open()
    {
        $this->connect = mysqli_connect($this->host,$this->user,$this->pass);

        if ( !$this->connect ) {
            echo "데이타 베이스 연결에 실패했습니다.";
            exit;
        }

        $db = mysqli_select_db($this->connect, $this->dbname);

        if ( !$db ) {
            echo "해당 데이타 베이스가 없습니다.";
            exit;
        }
        
        if ( !mysqli_query($this->connect, "use $this->dbname") ) {
            echo "해당 데이타 베이스를 사용할수 없습니다.";
            exit;
        }
        //mysqli_query($this->connect, "SET NAMES 'utf8'");   // utf8 형식으로 변환
        //mysqli_query($this->connect, "SET CHARSET 'utf8'"); // utf8 형식으로 변환
    }

    function sql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    function sql_affected_rows($result)
    {
        return @mysqli_affected_rows($result);
    }

    function sql_num_fields($result)
    {
        return mysqli_num_fields($result);
    }

    function sql_fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }

    function sql_fetch_array($result)
    {
        return mysqli_fetch_array($result);
    }

    function sql_insert_id()
    {
        return @mysqli_insert_id($this->connect);
    }

    function next_record($result)
    {
        $this->record = mysqli_fetch_array ($result);
        $this->row += 1;
        $this->Errono = mysqli_connect_errno();
        $this->Error = mysqli_connect_error();

        $stat = is_array($this->record);
        if ( !$stat ) {
            mysqli_free_result($result);
            $this->result = 0;
        }
        return $stat;
    }

    function exec_sql($sql)
    {
        $this->result = mysqli_query($this->connect, $sql);
        $this->row = 0;
        $this->Errono = mysqli_connect_errno();
        $this->Error = mysqli_connect_error();
        
        if (mysqli_connect_errno()) {
            echo 0;
            //echo "Error No {$this->Error} \nSQL Query 에 문제가 있습니다.\n $sql ";
            exit;
        }
        return $this->result ;
    }

    function db_close()
    {
        $ret = mysqli_close($this->connect);
        $this->connect = null;
        return $ret ;
    }
}