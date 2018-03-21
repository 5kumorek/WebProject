<?php
class Product{
 
    // database connection and table name
    private $db;
    private $table_name;
 
 
    // constructor with $db as database connection
    public function __construct($db, $table_name){
	$this->table_name = $table_name;
        $this->db = $db;
    }
//******************************************//
	// read products
	public function readAll($columns){
	    // select all query
		$my_query = 'SELECT * from ' . $this->table_name . ';';
		//echo $my_query;
		$result = $this->db->query($my_query);
		$records;
		 while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
       			foreach($columns as $element) { 
				$records .= $row[$element] . " ";
			}
			$records .= "<br>";
   		 }
		return $records;
	}
//******************************************//
	public function getRows($columns){
	    // select all query
		$my_query = 'SELECT * from ' . $this->table_name . ';';
		//echo $my_query;
		$result = $this->db->query($my_query);
		$records = array();
		 while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$inside_array=array();
       			foreach($columns as $element) { 
				array_push($inside_array, $row[$element]);
			}
			array_push($records, $inside_array);
   		 }
		//$records = array('id', 'name', 'quantity');	
		return $records;
	}
//******************************************//
public function getData($columns){
	    // select all query
		$my_query = 'SELECT * from ' . $this->table_name . ';';
		//echo $my_query;
		$result = $this->db->query($my_query);
		$names = array();
		$quantities = array();
		 while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($names, $row['name']);
			array_push($quantities, $row['quantity']);
   		 }
		$sum;
		foreach($quantities as $element) {
				$sum+= $element;
			}
		foreach($quantities as &$element) {
				$element=($element/$sum)*100;
			}
		$records = array('names'=>$names, 'quantities'=>$quantities);	
		return $records;
	}
//******************************************//
public function insert($columns, $values){
 
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "(";

	foreach($columns as $element) {
		
		if($i++!=0) {
			$query .=", ";		
		}
		$query .= $element;
	}

 	$query .= ") values (";
	$i=0;
	foreach($values as $element) {
		
		if($i++!=0) {
			$query .=", ";		
		}
		$query .= $element;
	}
 	$query .= ");";
	$result = $this->db->exec($query);
	//return $query;
	if($result)
		return true;
	return false;
}
    /* prepare query
    $stmt = $this->conn->prepare($query);
 
     sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->created=htmlspecialchars(strip_tags($this->created));
 
     bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);
 
     execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}*/
//******************************************//
// used when filling up the update product form
/*function readOne(){
 
    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->description = $row['description'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
}
//******************************************
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id = :category_id
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
//******************************************
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
//******************************************
function search($keywords){
 
    // select all query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}*/
}
