<?php
/*
* Auther : Nirav Trivedi
* Defination : Database operations
* Audiance : Developers
* Contact Me : nirav.trivedi29@gmail.com
* Contact Subject : "From PHPClasses.org" <your subject line>
* Free to use , modify and re-distribute it.
* Only one request please keep my creadit.
*/
class Database{
	var $order_by = '';
	var $limit = '';
	var $start = 0;
	var $group_by = '';
	var $shq = false;
	public function __contruct(){
	   //
	}
	public function run($sql)
	{
	  if($sql)
            {
		$this->res = mysql_query($sql);
		if(!$this->res)
		{
		  echo "<div>ERROR No.:: ".mysql_errno()."</div>";
		  echo "<div>ERROR :: ".mysql_error()."</div>";
	          echo "<div>Query :: ".$sql."</div>";
		}
		$this->CleanUp(); // clean up all set variable.
		return $this->res;
	    }else {
		exit('Missing Argument');
		}
	}
	public function insert($table,array $data,$ignore=false)
	{
	 foreach($data as $key=>$value) 
	 {
		$ky[] = $key;
		$val[] ='"'.addslashes(trim($value)).'"';
	 }
	 $key = implode(",",$ky);
	 $val = implode(",",$val);
	 if($ignore == true)
	    {
		$ins = "INSERT IGNORE INTO $table (".$key.") VALUES (".$val.")";
	    }
	else
	   {
		$ins  = "INSERT INTO $table (".$key.") VALUES (".$val.")";
	   }
	  $this->insR =  $this->run($ins);
	  $this->InserId = $this->insertID();
	 return $this->insR;
	}
	public function update($table,array $data,$cond='')
	{
	 $limit  = (isset($this->limit)) ? "LIMIT ".$this->limit : "";
	 foreach($data as $key=>$value)
	 {
	  $uQ[] = $key.' = '.'"'.addslashes(trim($value)).'"'; // TODO as per your requirement
	 }
	 $cond = preg_replace("/WHERE/i","",$cond);
	 $cond = (trim($cond)!='') ? "WHERE ".$cond : "";
	 $uQ = implode(",",$uQ);
	 $sql = "UPDATE $table SET $uQ $cond $limit";
	 $this->upR = $this->run($sql);
	 $this->affected = $this->AffectedR();
	 return $this->upR;
	}
	public function select($table,$field='*',$cond='')
	{
		$start = (isset($this->start) && $this->start>0) ? $this->start : '0';
		$limit = (isset($this->limit) && $this->limit > 0) ? "LIMIT $start,$this->limit" : "";
		$order_by = (isset($this->order_by) && trim($this->order_by)!='') ? "ORDER BY ".$this->order_by : "";
		$group_by = (isset($this->group_by) && trim($this->group_by)!='') ? "GROUP BY ".$this->group_by : "";
		if(is_array($cond))
		{
		     $contact = '';
		     
		     foreach($cond as $keyOp =>$fOp)
		     {
		        if($keyOp == 'CONCATE' and count($cond)>1) //fixed if only one key.
                    {
                     $concate = $value;
                    }
		        foreach($fOp as $key => $value)
		        {
		          if(trim($key)!='' and trim($value)!='')
		          {
		             $whr[] = $key .' = "'.$value.' " ';
		          }
		        }
		        $w[] = implode(" $keyOp ",$whr);
		        unset($whr);
		     }
		   $cond=implode(" $contact ",$w);
		}
         	$cond = preg_replace("/WHERE/i",'',$cond);		
		$cond = (trim($cond)!='') ? "WHERE ".$cond : "";
		//You can add more conditions
          $sql = "SELECT $field FROM $table $cond $group_by $order_by $limit";
		if($this->shq == true)
		{
		 exit($sql); //you can change according to your use
		}
		$this->sel = $this->run($sql);
		return $this->sel;
		
	}
	public function insertID()
	{
	 return mysql_insert_id();
	}
	public function fetch($res='')
	{
	 $r = $this->sel;
	 if($res)
	 {
	  $r = $res;
	 }
      return mysql_fetch_array($r,MYSQL_ASSOC);
	}
	public function NumRows($res='')
	{
	 $re = $this->sel;
	 if($res)
         {
	   $re = $res;
	 }
	 return mysql_num_rows($re);
	}
	/*
	* Param  : $table = table name
	*          $fields = Field you want to retrive , $cond = condition
	*/
	public function AffectedR()
	{
	     return mysql_affected_rows();
	}
	/*
	* find number of rows
	*/
	public function Count($table,$cond='',$grBy = false)
	{
	 $cond = preg_replace("/WHERE/i","",$cond);
	 $cond = (trim($cond)!='') ? "WHERE ".$cond : "";
	 $group_by = (isset($this->group_by) && trim($this->group_by)!='') ? "GROUP BY ".$this->group_by : "";
	 $sql = "SELECT COUNT(*) AS CNT FROM $table $cond $group_by";
	 $this->cntR = $this->run($sql);
	 if(preg_match("/GROUP BY/i",$sql))
	 {
	     $this->count = $this->NumRows($this->cntR);
	     return  $this->count;
	 }else{
	     $c = $this->fetch($this->cntR);
	     return $c['CNT'];
	 }
	}
	
	public function fire($table,$cond='')
	{
	 $cond = $cond = preg_replace("/WHERE/i","",$cond);
	 $cond = (trim($cond)!='') ? "WHERE ".$cond : "";
	}
	public function CleanUp()
	{
		$this->order_by = NULL;
		$this->limit = NULL;
		$this->start = NULL;
		$this->group_by = NULL;
		$this->shq = false;
	}
}
?>
