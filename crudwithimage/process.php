<?php
//start a session
session_start();
//connecting to database
$mysqli = new mysqli('localhost', 'root', '', 'crudtest') or die (mysqli_error($mysqli));
//set our inputs to empty strings so as to check whether edit button has been clicked
//and if the id is accessed when editing and updating a record
//the empty quotations set the variables as global variables
$id = 0;
$update = false;
$name = "";
$prodname = "";
$rating = "";
$duration = "";
$size = "";
$genre = "";
$release_date = "";
$poster_image = "";
$updateSql = "";
//check if submit button is pressed
//access using global variable $_POST
//the isset function checks if a condition has been met
//save is the name of the button
if (isset($_POST['save'])) {
    //this is the path that will store our image 
    $target = "pictures/" . basename($_FILES['pimage']['name']);
    //store name and location in variables
    //the name in the [] is the name of the input in the form on index.php
    $name = $_POST['moviename'];
    $prodname = $_POST['prodname'];
    $rating = $_POST['ratings'];
    $duration = $_POST['duration'];
    $size = $_POST['size'];
    $genre = $_POST['genre'];
    $release_date = $_POST['date'];
    //image code
    $poster_image = $_FILES['pimage']['name'];
    //sql query to insert
    //the first () is where u declare the column names in the database
    //the second () is where u map the value of the input from the user
    $insert = "INSERT INTO data (name, producer, rating, duration, size, genre,date, poster_image)VALUES ('$name','$prodname','$rating','$duration','$size','$genre','$release_date','$poster_image')";
    //placing image to the folder pictures so we can have a path to retrieve it from
    if (mysqli_query($mysqli, $insert)) {
        # code...
        move_uploaded_file($_FILES['pimage']['tmp_name'], $target);
        //check if image has been moved
        echo "<script>alert('image has been moved')</script>";
    } else {
        echo "<script>alert('image has not been moved')</script>";
    }
    //setting messages for the save button and a bootstrap message type
    $_SESSION['message'] = "Movie added successfully";
    $_SESSION['msg_type'] = "success";
    //redirect user to index.php for message
    header("location: index.php");
}

//UPDATE FUNCTION
//check if edit button is clicked 
if (isset($_GET['edit'])) {
    # code...
    $id = $_GET['edit'];
    //variable update
    $update = true;
    //pulling requested record 
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error);
    //check if the record to be edited exists in my database
    //the names in the square brackets are names of your column in the database
    $row = $result->fetch_array();
    $name = $row['name'];
    $prodname = $row['producer'];
    $rating = $row['rating'];
    $duration = $row['duration'];
    $size = $row['size'];
    $release_date = $row['date'];
    $genre = $row['genre'];
}

//updataing and editing records
//check if the update button has been clicked 
if (isset($_POST['update'])) {
    //path for updated image
    $newtarget = "pictures/" . basename($_FILES['pimage']['name']);

    # code...
    //the name in the square brackets of the $_POST submission are the name of the inputs in ur form
    $id = $_POST['id'];
    $name = $_POST['moviename'];
    $prodname = $_POST['prodname'];
    $rating = $_POST['ratings'];
    $duration = $_POST['duration'];
    $size = $_POST['size'];
    $genre = $_POST['genre'];
    $release_date = $_POST['date'];
    //using the unlink function to delete old images
    $poster_image = $_FILES['pimage']['name'];
   //new query for updates
   $updateSql =  "UPDATE data SET name='$name', genre='$genre', producer='$prodname', rating='$rating', duration='$duration', size='$size', date='$release_date', poster_image = '$poster_image' WHERE id='$id' ";
   //deleting existing image using unlink function
    unlink("pictures/$poster_image");

    //placing image to the folder pictures so we can have a path to retrieve it from
    if (mysqli_query($mysqli, $updateSql)) {
        # code...
        move_uploaded_file($_FILES['pimage']['tmp_name'], $newtarget);
        //check if image has been moved
        //setting session messages for updates
        $_SESSION['message'] = "Record has been updated";
        $_SESSION['msg_type'] = "warning";
        //redirect
        header("location: index.php");
    } else {
        echo "<script>alert('image has not been moved')</script>";
        header('location: index.php');
    }


    //setting session messages for updates 
    $_SESSION['message'] = "Record has been updated";
    $_SESSION['msg_type'] = "warning";
    //redirect
    header("location: index.php");
}

//deleting a record
//first check if delete button is clicked
if (isset($_GET['delete'])){
    //deleting record using the id
    $id = $_GET['delete'];
    //SQL Query for fetching the id for the row deleted
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error);
    //setting message and message type for the save button
    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
    //redirecting user back to index.php
    header("location: index.php");


}














































