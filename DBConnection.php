<?php

class DBConnection{

     private $con;
     private $resultSet;
     private $statement;

     private $DB_NAME = 'BultokochiColleges';
     private $TABLE_NAME = 'StudentRecord';

     public function __construct(){
          $this->con = new mysqli("localhost", "root", "", $this->DB_NAME);
     }

     //open and close
     public function startConnection(){
          $this->con = new mysqli("localhost", "root", "", $this->DB_NAME);
     }
     public function closeConnection(){
          $this->con->close();
     }
     public function closeStatement(){
          $this->statement->close();
     }

     public function executeComd($statement, $isUpdate){

          if($isUpdate == TRUE){
               $statement->execute();
          }else if ($isUpdate == FALSE){
               $this->resultSet = $statement->execute();
          }

          $this->statement = $statement;
     }

     public function getConnection(){
          return $this->con;
     }

     public function getData(){
          return $this->resultSet;
     }

     public function getTableName(){
          return $this->TABLE_NAME;
     }

     public function getStatement(){
          return $this->statement;
     }

     public static function printResultSet($stmt, $resultSet){

          if($resultSet == TRUE){

               $stmt->bind_result($studno, $studname, $admisyear, $stat, $bdate, $yearlevel, $dept);

               echo "<table border=2 cellpadding=10px>";

               echo "<tr>";
               echo "<td><p style=\"text-align:center;\"><b> Student No </b></p></td>";
               echo "<td><p style=\"text-align:center;\"><b> Student Name </b></p></td>";
               echo "<td><p style=\"text-align:center;\"><b> Admission Year </b></p></td>";
               echo "<td><p style=\"text-align:center;\"><b> Status </b></p></td>";
               echo "<td><p style=\"text-align:center;\"><b> Birthdate </b></p></td>";
               echo "<td><p style=\"text-align:center;\"><b> Year Level </b></p></td>";
               echo "<td><p style=\"text-align:center;\"><b> Department </b></p></td>";
               echo "</tr>";

               while($stmt->fetch()){
                    echo "<tr>";

                    echo "<td><p>" .$studno. "</p></td>";
                    echo "<td><p>" .$studname. "</p></td>";
                    echo "<td><p>" .$admisyear. "</p></td>";
                    echo "<td><p>" .$stat. "</p></td>";
                    echo "<td><p>" .$bdate. "</p></td>";
                    echo "<td><p>" .$yearlevel. "</p></td>";
                    echo "<td><p>" .$dept. "</p></td>";

                    echo "</tr>";
               }
               echo "</table>";
          }else{
               echo "<p><b>NO RESULT</b></p>";
          }

     }

}

?>
