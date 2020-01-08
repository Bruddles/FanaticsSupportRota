<?php

//Incorporating the 'Database' and 'DevelopmentTeam' classes
include_once ('Models/Database.php');
include_once ('Models/DevelopmentTeam.php');
/*
 * Class that maintains the interaction between the database and the client for the development team data
 */

class DevelopmentTeamDataSet
{

    //Establish DB connection
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //Creates a development team
    public function addDevTeam($teamName){
        $sqlQuery = 'INSERT INTO development_teams VALUES ("?")';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute([$teamName]);
    }

    //Deletes a development team
    public function delDevTeam($teamName){
        $sqlQuery = 'DELETE FROM development_teams WHERE name ='.$teamName;
        $sqlQuery = $this->_dbHandle->prepare($sqlQuery);
        $sqlQuery->execute();
    }

    //Returns an array of Development teams.
    public function getDevelopmentTeams(){
        //Fetches all the development teams and creates an array of 'DevelopmentTeam' objects
        $sqlQuery = 'SELECT * FROM development_teams';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new DevelopmentTeam($row);
        }
        return $dataSet; //return the array
    }

    //Add a user to the development team.
    public function joinDevTeam($teamName, $username)
    {
        //Set the 'development_team' to the required team name for the correct user.
        $sqlQuery = 'UPDATE users SET development_team = '.$teamName.' WHERE username = '.$username;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

}