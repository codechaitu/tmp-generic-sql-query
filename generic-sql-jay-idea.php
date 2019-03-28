

<?php
//Find this code online and run: https://paiza.io/projects/fDRfKeXELNIlI_GB1HxeGw

function main(){
// 1) Declaration of required variables
$varSelect = $whereClause = $constraintClause = "";

// 2) Read the variables from ENDPOINT call
$varSelect = "user_id, id";
$whereClause = "status = active AND (expiration_date IS NULL OR expiration_date > NOW())";
$constraintClause = "force index(user_id)";

// 3) Variables needed for this code
$sqlQuery = "";

// Check if selectClause and whereClause have values and they are valid
if(!empty($whereClause) && !empty($varSelect)){
    $constraints = multiexplode(array("AND","OR"), $whereClause);
    if(count($constraints)>1){
        echo "There are multiple where clause conditions\n";
        // Validation needed here
    }else{
        echo "There is only one condition, need to validate it.\n";
        // Validation needed here
    }
    
    // Preparing SQL query
    if(!empty($constraintClause)){
        $sqlQuery = $sqlQuery."SELECT ".$varSelect." FROM ACL ".$constraintClause." ".$whereClause;
    }else{
        $sqlQuery = $sqlQuery."SELECT ".$varSelect." FROM ACL ".$whereClause;
    }
    echo $sqlQuery;
    
}else{
    echo "Where/Select clause is empty; Not accepted";
}
}

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}


// 0) Calling the main function
main();
?>
