<pre>
<?php
include "config.php";
include_once "Database.php";

$db = new Database();
/*
* Insert Example
*/

$post = array('email_user'=>'nirav.trivedi29@gmail.com','password'=>'test');
$db->insert('users',$post);
echo "Inseted Row ID is :: ".$db->InserId;
echo "<br>";

/*
* Select Example
*/
$db->select('users');
while($r=$db->fetch()){
     echo $r['email_user'];
     echo "<br>";
}
echo "<br>";
print_r($r);
echo "Total Rows : ", $db->NumRows();
echo "<br><br>";
/*
* Select with where
* You can use various conditions here such as like , regexp and etc...
*/
$db->select('users','*','id = 1');
$r = $db->fetch();
print_r($r);
echo "<br><br>";
/*
* Order by , group by ,limit , start examples
*/
     $db->order_by = 'id ASC';
     $db->start = 2;
     $db->limit = 4;
     $db->group_by = 'email_user';
     $db->select('users');
     while($r=$db->fetch()){
          echo $r['email_user'];
           echo "<br>";
     }
  echo "Total Rows : ", $db->NumRows();
  echo "<br>";
/*
* Update records
*/
     $post = array('email_user'=>'nirav_trivedi29@ymail.com');
     $db->update('users',$post,'id = 1');
     echo "Affected Rows : ", $db->affected;

echo "<br>";
/*
* Get total rows count
*/

echo  "Total Rows : ",$db->Count('users','user_type = "s"');
echo "<br>";
/*
* Row count with group by
*/

$db->group_by = 'email_user';
echo  "Total Rows Group by : ",$db->Count('users');

/*
* With where condition as array concate with AND
*/
$whr=array('AND'=>array('id'=>'1','user_type'=>'s'));
$db->select('users','*',$whr);
$r=$db->fetch();
print_r($r);

/*
* With where condition as array concate with AND
*/

$whr=array('OR'=>array('id'=>'0','user_type'=>'s'));
$db->select('users','*',$whr);
$r=$db->fetch();
print_r($r);


/*$a = array('AND'=>array('testa'=>'test','1'=>'a','2'=>'v'),'OR'=>array('f1'=>'v1','f2'=>'f55'),'CONCATE'=>'OR');
$where=$c='';
foreach($a as $key=>$value)
{
//      echo  $kkey = $key; echo "<br>";
     if($key == 'CONCATE')
     {
       $concate = $value;
     }

    foreach($value as $k=>$v)
    {
     $cnds[] = $k.' = "'.$v.'" ';
     $c .= $k.' = "'.$v.'" '.$key.'  ';
    }
    if(count($cnds)>0)
    {
      $condi[] = implode(" $key ",$cnds);
      $where .= implode(" $key ",$cnds);
    }
    
    unset($cnds);
}
//echo $c;
//print_r($cnds); 
echo "<br>";
print_r($condi);
echo implode(" $concate ",$condi);
*/     
?>
</pre>
