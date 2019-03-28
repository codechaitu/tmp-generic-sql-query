<?php
// Your code here!

function main(){
    
// 1) Declaration of all requrired variables
$varSelect = $forceIndexConstraint = $table = $user_id = $status = $useExpirationDate = $id  = "";

// 2) Get all the values from ENDPOINT request
$varSelect = "message";
$forceIndexConstraint = "user_id";
$table = "ACL";
$user_id = "123";
$status = "active";
$useExpirationDate = "true";
$id = "!null";


// 3) Get the variables that are only set
$nonEmptyVariables = array();
foreach(get_defined_vars() as $key=>$value){
    if(!empty($value)){
        $nonEmptyVariables[$key] = $value;
    }
}

// 4) Getting where condition variables here
$notWhereConditionVariables = array('varSelect', 'forceIndexConstraint', 'useExpirationDate', 'table');
$whereKeys = array();
$whereValues = array();
foreach($nonEmptyVariables as $key => $value){
    if(!in_array($key, $notWhereConditionVariables)){
        array_push($whereKeys, $key);
        array_push($whereValues, $value);
    }
}
$whereList = array_combine($whereKeys, $whereValues);



//-------------Building select clause ---------
$selectClauseStatment = "SELECT ". $varSelect;

//------------Building Table clause -----
$table = " FROM ".$table." ";

// ------------Building Where condition Clause------------
//$whereKeys = array('user_id','status','id');
//$whereValues = array($user_id,$status,$id);
//$whereList = array_combine($whereKeys, $whereValues);
//print_r($c);

$whereClauseStatement = "WHERE ";
$loopCounter = 1;
$lenWhileList =  count($whereList);
foreach ($whereList as $key=>$value){
    // To capture the exception of 'is not null' usage in sql queries and make sure comparision is case-insensitive
    if(strcasecmp($value,"!NULL") == 0){
        $whereClauseStatement .= $key ." is not NULL ";
        continue;
    }
    if($loopCounter < $lenWhileList){
        $whereClauseStatement .= $key ." = " . $value. " AND ";
        
    }else{
        $whereClauseStatement .= $key ." = " . $value;
    }
    $loopCounter = $loopCounter + 1;
}

// Condition check for expiration date
if($useExpirationDate == "true"){
    $whereClauseStatement .= " AND (expiration_date IS NULL OR expiration_date > NOW()) ";
}

// condition check for usage of force constarint
if($forceIndexConstraint){
      $sqlQuery = $selectClauseStatment . $table ." force constraint(". $forceIndexConstraint.") " . $whereClauseStatement;
}else{
      $sqlQuery = $selectClauseStatment . $table . $whereClauseStatement;
}

echo $sqlQuery;

}
main();
?>
