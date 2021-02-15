<?php
//Connect to the db
    require_once('database.php');
    // Store item number into variable, grabbed from form POST method
    $itemNum = filter_input(INPUT_POST, "ItemNum", FILTER_VALIDATE_INT);


    // Delete the item from the database using Item Number and form data

        if($itemNum != false){
            $query =  'DELETE FROM todoitems 
            WHERE ItemNum = :ItemNum';
            $statement = $db->prepare($query);
            $statement->bindValue(':ItemNum', $itemNum);
            $success = $statement->execute();
            $statement->closeCursor();
        }
//Reload index.php to display results
        header("Location: index.php");
        
?>