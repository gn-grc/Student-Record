<?php

require 'DBConnection.php';

class StudentDataObject{

     private $connection;

     private $tableName;

     public function __construct($dbCon){
          $this->connection = $dbCon;

          $this->tableName = $dbCon->getTableName();
     }

     //$values is an associative array
     public function updateRecord($values){

          /*----opening connection----*/
          $this->connection->startConnection();

          $stmt = $this->connection->getConnection()->prepare("
            UPDATE $this->tableName
            SET STUDENTNAME   = ?,
            ADMISSIONYEAR     = ?,
            STATUS            = ?,
            BIRTHDAY          = ?,
            YEARLEVEL         = ?,
            DEPARTMENT        = ?
            WHERE STUDENTNO   = ?
            ");

          $stmt->bind_param("sissisi",
                            $values['studname'],
                            $values['admisyear'],
                            $values['stat'],

                            $values['birth'],
                            $values['yearlevel'],
                            $values['dept'],

                            $values['studno']
                          );

          $this->connection->executeComd($stmt, TRUE);

          /*----closing connection----*/
          $this->connection->closeConnection();
          /*----closing statement----*/
          $this->connection->closeStatement();

     }

     public function deleteRecord($studNum){

     }

     //$values is an associative array
     public function addRecord($values){

          /*----opening connection----*/
          $this->connection->startConnection();

          $stmt = $this->connection->getConnection()->prepare("
          INSERT INTO $this->tableName (
               STUDENTNAME,
               ADMISSIONYEAR,
               STATUS,
               BIRTHDAY,
               YEARLEVEL,
               DEPARTMENT
          )
          VALUES (?, ?, ?, ?, ?, ?)
          ");

          $stmt->bind_param("sissis",
                           $values['studname'],
                            $values['admisyear'],
                            $values['stat'],

                            $values['birth'],
                            $values['yearlevel'],
                            $values['dept']
                           );

          $this->connection->executeComd($stmt, TRUE);

          /*----closing connection----*/
          $this->connection->closeConnection();
          /*----closing statement----*/
          $this->connection->closeStatement();
     }

     public function getStudents(){

          /*----opening connection----*/
          $this->connection->startConnection();

          $stmt = $this->connection->getConnection()->prepare("
          SELECT * FROM $this->tableName
          ");

          $this->connection->executeComd($stmt, FALSE);

     }

     public function getStudentByStudentNumber($studno){

          /*----opening connection----*/
          $this->connection->startConnection();

          $stmt = $this->connection->getConnection()->prepare("
          SELECT * FROM $this->tableName
          WHERE StudentNo = ?
          ");

          $stmt->bind_param("i", $studno);

          $this->connection->executeComd($stmt, FALSE);

     }

     public function returnResult(){
          return $this->connection->getData();
     }

     public function getConnectionObject(){
          return $this->connection;
     }
}

$db = new DBConnection();
$sdo = new StudentDataObject($db);

$arr = array("studno"=>2017103610, "studname"=>'Vice Ganda', "admisyear"=>2000, "stat"=>'ALUMNI', "birth"=>'3/31/1899', "yearlevel"=>4, "dept"=>'COLLEGE');

$sdo->getStudents();

DBConnection::printResultSet( $sdo->getConnectionObject()->getStatement(), $sdo->getConnectionObject()->getData() );
$sdo->getConnectionObject()->closeConnection();
$sdo->getConnectionObject()->closeStatement();

?>
