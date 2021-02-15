<?php

//Make connection to DB
require_once('database.php');

//Filter Insert variables, if not there they'll be false
    $newTitle = filter_input(INPUT_POST, "newTitle", FILTER_SANITIZE_STRING);
    $newDescription = filter_input(INPUT_POST, "newDescription", FILTER_SANITIZE_STRING);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,300&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
<header>
<h1>ToDo List</h1>
</header>



<?php

//Run query to load the item list when the page is loaded

$queryItems = 'SELECT * FROM todoitems';
$statement = $db->prepare($queryItems);
$statement->execute();
$results = $statement->fetchAll();
$statement->closeCursor();


//Display message if the database is empty
        if(empty($results)) {
            echo "<h2 class='empty_message'>The Database is empty, please add a new item below.</h2>";
        }


?>
<main> 
<section class="item-list" aria-label="Item List Section">

<!-- Display item results -->
    <ul>
    <?php foreach ($results as $result) : ?>
    <li><?php echo $result['Title'];?>
    <br>
    <?php echo $result['Description'];?>

<!-- Delete button -->
    <form action="delete_item.php" method="POST">
    <input type="hidden" name="ItemNum"
        value="<?php echo $result['ItemNum'];?>">
    <input class="button delete_bttn" type="submit" value="X">
    </form>
    </li>
    <?php endforeach; ?>
    </ul>
</section>


<!-- Add item form and button -->
<section class="form-sect" aria-label="New Item Input Section">
    <h2>Add Item</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="newTitle">Item Title:</label>
        <input type="text" id="newTitle" name="newTitle" maxlength="20">
        <br>
        <label for="newDescription">Item Description:</label>
        <input type="text" id="newDescription" name="newDescription" maxlength="50">
        <br>
        <button class="button submit_bttn" type="submit" aria-label="submit a new item">Add Item</button>
    </form>
    <?php 

    // Insert Statement using form data and variables
    if($newTitle && $newDescription) {
        $query = 'INSERT INTO todoitems
            (title, description)
            VALUES(:newTitle, :newDescription)';

        $statement = $db->prepare($query);
        $statement->bindValue(':newTitle', $newTitle);
        $statement->bindValue(':newDescription', $newDescription);
        $statement->execute();
        $statement->closeCursor();
        //Reload the current page, to display results
        header("Location: .");
    }
?>



    </section>
</main>
</div>
</body>
</html>