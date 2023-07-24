<?php
class user #!
{
	private $login;
	private $name;
	private $password;
	private $role;
	public function __construct(string $login, string $name, string $password, string $role){
		$this->login=$login;
		$this->name=$name;
		$this->password=$password;
		$this->role=$role;
	}
	public function add(){
	$conn = sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
		if( $conn ){  
			$proc="Adduser";
			$params=array($this->login,$this->password,$this->name);
			$sql= "exec ".$proc." ?, ?, ?";
			$stmt = sqlsrv_prepare($conn , $sql, $params);
			if (!sqlsrv_execute($stmt)) {	
				  if( ($errors = sqlsrv_errors() ) != null)  
				  {  
					 foreach( $errors as $error)  
				  {  if ( $error[ 'code'] == "15023"){
					echo "Такое имя пользователя уже существует!<br>";
				  }
				  if ( $error[ 'code'] == "15025")
					  echo "Такой логин уже существует!<br>";
				  }}	
			return false;
			}
			if ($this->role=='user'){
				$sql="grant select, update, delete, insert to ".$this->name."";}
			elseif ($this->role=='admin'){
				$sql="alter role db_owner add member ".$this->name." 
				alter server role serveradmin add member ".$this->login."
				alter server role dbcreator add member ".$this->login;}
			$stmt = sqlsrv_query($conn, $sql);
			if ($stmt === false){
				echo "Ошибка! Права для пользователя ".$this->name." не предоставлены!";
			}
			return true;
			}
		else { echo "Ошибка! Подключение к БД не установлено!";
			return false;}
	 sqlsrv_close( $conn );
	}
}
class adres #!
{
public $cols=['Adr_id', 'City','Street','House','Flat', 'OwnerUser'];
	private $conn;
	private $id;
	private $city;
	private $street;
	private $house;
	private $flat;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->city=empty($params['City'])? 'NULL' : mb_convert_encoding("'".$params['City']."'", 'windows-1251', 'UTF-8');
	$this->street=empty($params['Street'])? 'NULL' : mb_convert_encoding("'".$params['Street']."'", 'windows-1251', 'UTF-8');
	$this->house=empty($params['House'])? 'NULL' : mb_convert_encoding("'".$params['House']."'", 'windows-1251', 'UTF-8');
	$this->flat=empty($params['Flat'])? 'NULL' : mb_convert_encoding("'".$params['Flat']."'", 'windows-1251', 'UTF-8');
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Adres where Adr_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Adres";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Adres values(".$this->city.",".$this->street.",".$this->house.",".$this->flat.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Adres set ".$field."=".$value." where Adr_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	
}
class branch #!
{
public $cols=['Br_id', 'City','Street','House','Phonenum','Email','OwnerUser'];
	private $conn;
	private $id;
	private $city;
	private $street;
	private $house;
	private $phonenum;
	private $email;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->city=empty($params['City'])? 'NULL':mb_convert_encoding("'".$params['City']."'", 'windows-1251', 'UTF-8');
	$this->street=empty($params['Street'])? 'NULL':mb_convert_encoding("'".$params['Street']."'", 'windows-1251', 'UTF-8');
	$this->house=empty($params['House'])? 'NULL':mb_convert_encoding("'".$params['House']."'", 'windows-1251', 'UTF-8');
	$this->phonenum=empty($params['Phonenum'])? 'NULL':mb_convert_encoding("'".$params['Phonenum']."'", 'windows-1251', 'UTF-8');
	$this->email=empty($params['Email'])? 'NULL':mb_convert_encoding("'".$params['Email']."'", 'windows-1251', 'UTF-8');
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Branch where Br_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Branch";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Branch values(".$this->city.",".$this->street.",".$this->house.",".$this->phonenum.",".$this->email.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Branch set ".$field."=".$value." where Br_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	
}
class clients #!
{
public $cols=['Client_id', 'Surname','Midname','Gender','Email'];
	private $conn;
	private $id;
	private $surname;
	private $midname;
	private $gender;
	private $email;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->surname=empty($params['Surname'])? 'NULL':mb_convert_encoding("'".$params['Surname']."'", 'windows-1251', 'UTF-8');
	$this->midname=empty($params['Midname'])? 'NULL':mb_convert_encoding("'".$params['Midname']."'", 'windows-1251', 'UTF-8');
	$this->gender=empty($params['Gender'])? 'NULL':mb_convert_encoding("'".$params['Gender']."'", 'windows-1251', 'UTF-8');
	$this->email=empty($params['Email'])? 'NULL':mb_convert_encoding("'".$params['Email']."'", 'windows-1251', 'UTF-8');
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Clients where Client_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Clients";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Clients values(".$this->surname.",".$this->midname.",".$this->gender.",".$this->email.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Clients set ".$field."=".$value." where Client_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class goods #!
{
public $cols=['Good_id', 'Man_id','Goodname','Descript','Photo','Cost','Instock'];
	private $conn;
	private $id;
	private $mid;
	private $gname;
	private $desc;
	private $photo;
	private $cost;
	private $instock;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->mid=empty($params['Man_id'])? 'NULL':$params['Man_id'];
	$this->gname=empty($params['Goodname'])? 'NULL':mb_convert_encoding("'".$params['Goodname']."'", 'windows-1251', 'UTF-8');
	$this->desc=empty($params['Descript'])? 'NULL':mb_convert_encoding("'".$params['Descript']."'", 'windows-1251', 'UTF-8');
	$this->photo=empty($params['Photo'])? 'NULL':mb_convert_encoding("'".$params['Photo']."'", 'windows-1251', 'UTF-8');
	$this->cost=empty($params['Cost'])? 'NULL': $params['Cost'];
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Goods where Good_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Goods";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Goods values(".$this->mid.",".$this->gname.",".$this->desc.",".$this->photo.",".$this->cost.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
		public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Goods set ".$field."=".$value." where Good_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	
}
class manufacturers #!
{
public $cols=['Man_id','Manname', 'Email','Descript'];
	private $conn;
	private $id;
	private $mname;
	private $email;
	private $desc;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->mname=empty($params['Manname'])? 'NULL':mb_convert_encoding("'".$params['Manname']."'", 'windows-1251', 'UTF-8');
	$this->email=empty($params['Email'])? 'NULL':mb_convert_encoding("'".$params['Email']."'", 'windows-1251', 'UTF-8');
	$this->desc=empty($params['Descript'])? 'NULL':mb_convert_encoding("'".$params['Descript']."'", 'windows-1251', 'UTF-8');
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Manufacturers where Man_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Manufacturers";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Manufacturers values(".$this->mname.",".$this->email.",".$this->desc.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Manufacturers set ".$field."=".$value." where Man_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	
}
class ordcontent #!
{
public $cols=['Cont_id', 'Ord_id','Good_id','Quantity','OwnerUser'];
	private $conn;
	private $id;
	private $oid;
	private $gid;
	private $quant;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->oid=empty($params['Ord_id'])? 'NULL':$params['Ord_id'];
	$this->gid=empty($params['Good_id'])? 'NULL':$params['Good_id'];
	$this->quant=empty($params['Quantity'])? 'NULL':$params['Quantity'];
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Ordcontent where Cont_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Ordcontent";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Ordcontent values(".$this->oid.",".$this->gid.",".$this->quant.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}	
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Ordcontent set ".$field."=".$value." where Cont_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class orders #!
{
public $cols=['Ord_id', 'Cl_id','Staff_id','Br_id','Orddate','Prepay','Complete','Readytime','OwnerUser'];
	private $conn;
	private $id;
	private $clid;
	private $stid;
	private $brid;
	private $orddate;
	private $prepay;
	private $complete;
	private $readytime;
	private $owneruser;

	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->clid= empty($params['Cl_id'])? 'NULL':$params['Cl_id'];
	$this->stid= empty($params['Staff_id'])? 'NULL':$params['Staff_id'];
	$this->brid= empty($params['Br_id'])? 'NULL':$params['Br_id'];
	$this->orddate=empty($params['Orddate'])? 'NULL':"'".$params['Orddate']."'";
	$this->prepay= empty($params['Prepay'])? 'NULL':$params['Prepay'];
	$this->complete=is_null($params['Complete'])? 'NULL': (int)$params['Complete'];
	$this->readytime=empty($params['Readytime'])? 'NULL': "'".$params['Readytime']."'";
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Orders where Ord_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Orders";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Orders values(".$this->clid.","
		.$this->stid.",".$this->brid.",".$this->orddate.",".$this->prepay.","
		.$this->complete.",".$this->readytime.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		if ($field!="Complete"){
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');}
		else{ is_null($value)? 'NULL' : (int)$value;}
		$sql="update Orders set ".$field."=".$value." where Ord_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class requestcontent #!
{
public $cols=['Cont_id','Req_id', 'Good_id','Quantity','OwnerUser'];
	private $conn;
	private $id;
	private $rid;
	private $gid;
	private $quant;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->rid=empty($params['Req_id'])? 'NULL':$params['Req_id'];
	$this->gid=empty($params['Good_id'])? 'NULL':$params['Good_id'];
	$this->quant=empty($params['Quantity'])? 'NULL':$params['Quantity'];
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Requestcontent where Cont_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Requestcontent";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Requestcontent values(".$this->rid.",".$this->gid.",".$this->quant.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Requestcontent set ".$field."=".$value." where Cont_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	
}
class requests #!
{
public $cols=['Req_id', 'Supplier_id','Staff_id','Br_id','Reqdate','Complete','OwnerUser'];
	private $conn;
	private $id;
	private $supid;
	private $stid;
	private $brid;
	private $reqdate;
	private $complete;
	private $owneruser;

	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->supid=empty($params['Supplier_id'])? 'NULL': $params['Supplier_id'];
	$this->stid= empty($params['Staff_id'])? 'NULL':$params['Staff_id'];
	$this->brid= empty($params['Br_id'])? 'NULL':$params['Br_id'];
	$this->reqdate=empty($params['Reqdate'])? 'NULL':"'".$params['Reqdate']."'";
	$this->complete= is_null($params['Complete'])? 'NULL':(int)$params['Complete'];
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Requests where Req_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Requests";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Requests values(".$this->supid.","
		.$this->stid.",".$this->brid.",".$this->reqdate.","
		.$this->complete.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		if ($field!="Complete"){
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');}
		else{ is_null($value)? 'NULL' : (int)$value;}
		$sql="update Requests set ".$field."=".$value." where Req_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class salecontent #!
{
public $cols=['Cont_id','Sale_id', 'Good_id','Quantity','OwnerUser'];
	private $conn;
	private $id;
	private $saleid;
	private $gid;
	private $quant;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->saleid=empty($params['Sale_id'])? 'NULL':$params['Sale_id'];
	$this->gid=empty($params['Good_id'])? 'NULL':$params['Good_id'];
	$this->quant=empty($params['Quantity'])? 'NULL':$params['Quantity'];
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Salecontent where Cont_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Salecontent";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Salecontent values(".$this->saleid.",".$this->gid.",".$this->quant.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Salecontent set ".$field."=".$value." where Cont_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class sales #!
{
public $cols=['Sale_id', 'Br_id','Cl_id','Staff_id','Saledate', 'Salesum','OwnerUser'];
	private $conn;
	private $id;
	private $brid;
	private $clid;
	private $stid;
	private $saledate;
	private $owneruser;

	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->brid=empty($params['Br_id'])? 'NULL': $params['Br_id'];
	$this->clid=empty($params['Cl_id'])? 'NULL':$params['Cl_id'];
	$this->stid=empty($params['Staff_id'])? 'NULL':$params['Staff_id'];
	$this->saledate=empty($params['Saledate'])? 'NULL':"'".$params['Saledate']."'";
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Sales where Sale_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Sales";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Sales values(".$this->brid.","
		.$this->clid.",".$this->stid.",".$this->saledate.","
		.$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Sales set ".$field."=".$value." where Sale_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class staff #!
{
public $cols=['Staff_id','Adr_id', 'Surname','Midname','Lastname',
'Phonenum','Passeries','Pasnum','Issueby','Issuedate','Birthdate','OwnerUser'];
	private $conn;
	private $id;
	private $adid;
	private $sname;
	private $mname;
	private $lname;
	private $phone;
	private $passer;
	private $pasnum;
	private $issueby;
	private $issuedate;
	private $birthdate;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->adid=empty($params['Adr_id'])? 'NULL':$params['Adr_id'];
	$this->sname=empty($params['Surname'])? 'NULL':mb_convert_encoding("'".$params['Surname']."'", 'windows-1251', 'UTF-8');
	$this->mname=empty($params['Midname'])? 'NULL':mb_convert_encoding("'".$params['Midname']."'", 'windows-1251', 'UTF-8');
	$this->lname=empty($params['Lastname'])? 'NULL':mb_convert_encoding("'".$params['Lastname']."'", 'windows-1251', 'UTF-8');
	$this->phone= empty($params['Phonenum'])? 'NULL':$params['Phonenum'];
	$this->passer= empty($params['Passeries'])? 'NULL':$params['Passeries'];
	$this->pasnum=empty($params['Pasnum'])? 'NULL':$params['Pasnum'];
	$this->issueby=empty($params['Issueby'])? 'NULL': mb_convert_encoding("'".$params['Issueby']."'", 'windows-1251', 'UTF-8');
	$this->issuedate=empty($params['Issuedate'])? 'NULL':"'".$params['Issuedate']."'";
	$this->birthdate=empty($params['Birthdate'])? 'NULL': "'".$params['Birthdate']."'";
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Staff where Staff_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Staff";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Staff values(".$this->adid.","
		.$this->sname.",".$this->mname.",".$this->lname.","
		.$this->phone.",".$this->passer.",".$this->pasnum.",".$this->issueby.","
		.$this->issuedate.",".$this->birthdate.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Staff set ".$field."=".$value." where Staff_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	
}
class suppliers #!
{
public $cols=['Supplier_id', 'Supplier_name','Phone'];
	private $conn;
	private $id;
	private $supname;
	private $phone;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->supname=empty($params['Supplier_name'])? 'NULL':mb_convert_encoding("'".$params['Supplier_name']."'", 'windows-1251', 'UTF-8');
	$this->phone=empty($params['Phone'])? 'NULL':mb_convert_encoding("'".$params['Phone']."'", 'windows-1251', 'UTF-8');
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Suppliers where Supplier_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Suppliers";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Suppliers values(".$this->supname.",".$this->phone.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}	
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Suppliers set ".$field."=".$value." where Supplier_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class supply #!
{
public $cols=['Sup_id', 'Supplier_id','Br_id','Supdate','OwnerUser', 'Complete'];
	private $conn;
	private $id;
	private $supid;
	private $brid;
	private $supdate;
	private $owneruser;
	private $complete;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->supid=empty($params['Supplier_id'])? 'NULL': $params['Supplier_id'];
	$this->brid=empty($params['Br_id'])? 'NULL': $params['Br_id'];
	$this->supdate=empty($params['Supdate'])? 'NULL': "'".$params['Supdate']."'";
	$this->owneruser="'".$_SESSION['user']."'";
	$this->complete= is_null($params['Complete'])? 'NULL':(int)$params['Complete'];
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Supply where Sup_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Supply";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Supply values(".$this->supid.","
		.$this->brid.",".$this->supdate.",".$this->owneruser.",".$this->complete.")";
		$stmt = sqlsrv_query($this->conn, $sql);
			if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		if ($field!="Complete"){
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');}
		else{ is_null($value)? 'NULL' : (int)$value;}
		$sql="update Supply set ".$field."=".$value." where Sup_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
class supplycontent #!
{
public $cols=['Cont_id','Sup_id', 'Good_id','Quantity', 'OwnerUser'];
	private $conn;
	private $id;
	private $supid;
	private $gid;
	private $quant;
	private $owneruser;
	public function __construct(){
	$this->conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
	}
	public function __destruct(){
	sqlsrv_close($this->conn);
	}
	public function set($params){
	$this->supid=empty($params['Sup_id'])? 'NULL':$params['Sup_id'];
	$this->gid=empty($params['Good_id'])? 'NULL':$params['Good_id'];
	$this->quant=empty($params['Quantity'])? 'NULL':$params['Quantity'];
	$this->owneruser="'".$_SESSION['user']."'";
	}
	public function del($id){
		if ($this->conn)
		{
		$sql="delete from Supplycontent where Cont_id=".$id."";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		} 
	}
	public function select(){
	if ($this->conn)
		{
		$sql="select * from Supplycontent";
		$stmt = sqlsrv_query($this->conn, $sql);
		return $stmt;
		}
}
	public function insert(){
	if ($this->conn)
		{
		$sql="insert into Supplycontent values(".$this->supid.",".$this->gid.",".$this->quant.",".$this->owneruser.")";
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
	public function update($id,$field,$value){
	if ($this->conn)
		{
		$value=empty($value)? 'NULL' : mb_convert_encoding("'".$value."'", 'windows-1251', 'UTF-8');
		$sql="update Supplycontent set ".$field."=".$value." where Cont_id=".$id;
		$stmt = sqlsrv_query($this->conn, $sql);
		if ($stmt===false){ return false; }
		else {return true;}
		}
	}
}
?>
