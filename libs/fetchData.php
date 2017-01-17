<?php
class fetchData extends dbconnect
{
    private $sql;
    private $query;
    
    public function fetchAllRecord($table,$column,$sort = "desc")
    {
        $this->sql="SELECT * FROM $table ORDER BY $column $sort";
        $this->query=PDO::prepare($this->sql);
        $this->query->execute();
        
        if($this->query->errorCode()==0)
        {
            if($this->query->rowCount()==0)
                return 0;
            else   
                return $this->query->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $err=$this->query->errorInfo();
            return $err[2];
        }
    }
    
    public function fetchOneColumn($table,$column,$value)
    {
        $this->sql="SELECT * FROM $table WHERE $column = :value";
        $this->query=PDO::prepare($this->sql);
        $this->query->execute(array(':value'=>$value));
        
        if($this->query->errorCode()==0)
        {
            if($this->query->rowCount()==0)
                return 0;
            else   
                return $this->query->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $err=$this->query->errorInfo();
            return $err[2];
        }
    }
}
?>