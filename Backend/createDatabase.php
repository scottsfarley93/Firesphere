<?php
   $hostname = "localhost";
   $username = "Firesphere_Admin";
   $password = "HalfDome887!";
   
   
   $connection = new mysqli($hostname, $username, $password);
   if ($connection->connect_error){
   	die("Could not connect to database ". $connection->connect_error);
   }else{
   	echo "Connection successful.";
   }
   //create database
   $sql = "CREATE DATABASE IF NOT EXISTS Firesphere";
   if ($connection ->query($sql) === TRUE){
   	echo "Database creation successful.<br />";
   }else{
   	die("Failed to create database: " . $connection -> error . "<br />");
   }
   //make sure we use the correct database
   $sql = "USE Firesphere";
   if ($connection ->query($sql) === TRUE){
   	echo "Using Firesphere Database.<br />";
   }else{
   	die( "Failed to switch database: " . $connection -> error . "<br />");
   }
   
   //make tables
   
   //Users
   $sql = "CREATE TABLE IF NOT EXISTS Users(
   	UserID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	Username VARCHAR(50) NOT NULL,
   	First VARCHAR(50) NOT NULL,
   	Last VARCHAR(50) NOT NULL,
   	Email  VARCHAR(100) NOT NULL,
   	Password VARCHAR(255) NOT NULL,
   	Team VARCHAR(50) NOT NULL,
   	NumObs INT(11) NOT NULL,
   	Timestamp  TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "User Table creation successful.<br />";
   }else{
   die("Failed to create Users Table: " . $connection -> error . "<br />");
   }
   
   //Observations
   $sql = "CREATE TABLE IF NOT EXISTS Observations(
   	ObservationID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   	Username VARCHAR(50) NOT NULL,
   	FuelModel VARCHAR(50) NOT NULL,
   	Comments VARCHAR(255) NOT NULL,
   	ImageFilename  VARCHAR(255) NOT NULL,
   	Latitude DOUBLE NOT NULL,
   	Longitude DOUBLE NOT NULL,
   	Accuracy DOUBLE NOT NULL,
   	Timestamp  TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Observation Table creation successful.<br />";
   }else{
   die("Failed to create Observation Table: " . $connection -> error . "<br />");
   }
   
   //FuelsData
   $sql = "CREATE TABLE IF NOT EXISTS FuelsData(
   	FuelID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	SeriesName VARCHAR(50) NOT NULL,
   	Latitude DOUBLE NOT NULL,
   	Longitude DOUBLE NOT NULL,
   	ImageFilename VARCHAR(255) NOT NULL,
   	Type VARCHAR(100) NOT NULL,
   	Number INT(11) NOT NULL,
   	Name VARCHAR(100) NOT NULL,
   	Timestamp  TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Fuels Data Table creation successful.<br />";
   }else{
   die("Failed to create Fuels Data Table: " . $connection -> error . "<br />");
   }
   
    //Organizations
   $sql = "CREATE TABLE IF NOT EXISTS Organizations(
   	OrgID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	Name VARCHAR(100) NOT NULL,
   	NumMembers INT(11) NOT NULL,
   	NumObservations INT(11) NOT NULL,
   	Description VARCHAR(255) NOT NULL,
   	Timestamp  TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Organizations Table creation successful.<br />";
   }else{
   die("Failed to create Organizations Table: " . $connection -> error . "<br />");
   }
   
   //Feeback
   $sql = "CREATE TABLE IF NOT EXISTS Feedback(
   	FeedbackID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	Username VARCHAR(50) NOT NULL,
   	Name VARCHAR(255) NOT NULL,
   	Email VARCHAR(100) NOT NULL,
   	Subect VARCHAR(255) NOT NULL,
   	Comments LONGTEXT NOT NULL,
   	Timestamp  TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Feedback Table creation successful.<br />";
   }else{
   die("Failed to create Feedback Table: " . $connection -> error . "<br />");
   }
   
   
   //Forecast delta
   $sql = "CREATE TABLE IF NOT EXISTS ForecastDelta(
   	ForecastID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	Timestamp TIMESTAMP,
   	PredictedMean DOUBLE NOT NULL,
   	ActualMean DOUBLE NOT NULL,
   	DeltaMean DOUBLE NOT NULL,
      SD DOUBLE NOT NULL,
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Forecast Delta Table creation successful.<br />";
   }else{
   die("Failed to create Forecast Delta Table: " . $connection -> error . "<br />");
   }
   
      //Char Summary
   $sql = "CREATE TABLE IF NOT EXISTS CharacteristicSummary(
   	SummaryID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	Low DOUBLE NOT NULL,
   	Medium DOUBLE NOT NULL,
   	High DOUBLE NOT NULL,
   	VeryHigh DOUBLE NOT NULL,
   	Extreme DOUBLE NOT NULL,
   	NoBurn DOUBLE NOT NULL,
    Timestamp TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Characteristic Summary Table creation successful.<br />";
   }else{
   die("Failed to create Characteristic Summary Table: " . $connection -> error . "<br />");
   }
	
	
      //Fuel Moisture Summary
   $sql = "CREATE TABLE IF NOT EXISTS FuelMoisture(
   	FMID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   	One DOUBLE NOT NULL,
   	Ten DOUBLE NOT NULL,
   	Hundred DOUBLE NOT NULL,
   	Thousand DOUBLE NOT NULL,
   	Herbaceous DOUBLE NOT NULL,
   	Woody DOUBLE NOT NULL,
    Timestamp TIMESTAMP
   )";
   if ($connection ->query($sql) === TRUE){
   	echo "Fuel Moisture Table creation successful.<br />";
   }else{
   die("Failed to create Fuel Moisture Table: " . $connection -> error . "<br />");
   }	


   
      //Table of Run Dates
   $sql = "CREATE TABLE IF NOT EXISTS NFDRS_Runs(
      RunID INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
      Start TIMESTAMP,
      End TIMESTAMP,
      Duration DOUBLE NOT NULL,
      Success BOOLEAN NOT NULL
   )";
   if ($connection ->query($sql) === TRUE){
      echo "nfdrsRuns Table creation successful.<br />";
   }else{
   die("Failed to create nfdrsRuns Table: " . $connection -> error . "<br />");
   }  
?>