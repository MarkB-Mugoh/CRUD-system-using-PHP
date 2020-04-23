<html>
<head>
    <title>PHP CRUD</title>
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/css/bootstrap-theme.css">
    <meta charset="UTF-8">
    >
</head>
<body>
<!-- requiring our process file -->
<?php require_once 'process.php' ?>
<!-- checking if there is any session set -->
<?php
if (isset($_SESSION['message'])):
?>
    <!-- displaying my messages -->
    <!-- the div we are creating will use bootstrap classes to set a contextual alert type -->
<div class="container container-fluid">
    <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        session_destroy();
        ?>

    </div>
    <?php endif; ?>
</div>


<!-- use mysqli to fetch records from db -->
<?php
//connectting to db
$mysqli = new mysqli('localhost', 'root', '', 'crudtest') or die(mysqli_error($mysqli));
//do a query to select all our records
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
//printing output from function below
// pre_r($result);
//using fetch_assoc function to pull records
//pre_r($result->fetch_assoc());
?>
<!-- creating table to dispaly our data -->
<div class="container container-fluid">
    <table class="table">
        <thead>
        <tr>
            <th>Movie Name</th>
            <th>Producer</th>
            <th>Rating</th>
            <th>Duration(in hours)</th>
            <th>Size</th>
            <th>Genre</th>
            <th>Release Date</th>
            <th>Poster Image</th>
            <th colspan="2">Action</th>
        </tr>

        </thead>
        <!-- now we create a while loop to pull our record from database -->
        <?php
        while ($row = $result->fetch_assoc()):
            ?>
            <!-- display results in table cells i.e. td -->
            <!-- the name in the [] is the name of the columns in the table of ur database -->
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['producer'] ?></td>
                <td><?php echo $row['rating'] ?></td>
                <td><?php echo $row['duration'] ?></td>
                <td><?php echo $row['size'] ?></td>
                <td><?php echo $row['genre'] ?></td>
                <td><?php echo $row['date'] ?></td>
                <td><?php echo "<img src='pictures/" . $row['poster_image'] . "' style='width:100px; height:100px;'>" ?></td>
                <td>
                    <!-- edit button -->
                    <!-- appending edit name to my button -->
                    <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <!-- ending the while loop -->
        <?php
        endwhile;
        ?>


    </table>


</div>


<!-- function to dispaly our array -->
<?php
function pre_r($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

?>


<!-- form -->
<div class="container container-fluid">
    <form action="process.php" method="POST" enctype="multipart/form-data">
        <!-- hiding my id value  -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <!--  -->
        <div class="form-group">
            <label for="name">Movie Names</label>
            <input class="form-control" type="text" name="moviename" value="<?php echo $name; ?>">
        </div>
        <div class="form-group">
            <label for="producer">Producer Name</label>
            <input class="form-control" type="text" name="prodname" value="<?php echo $prodname; ?>">
        </div>
        <div class="form-group">
            <label for="rate">Rating</label>
            <input class="form-control" id="rate" placeholder="PG/G/A" type="text" name="ratings" value="<?php echo $rating; ?>">
        </div>
        <div class="form-group">
            <label for="duration">Duration(In hours)</label>
            <input class="form-control" id="duration" type="text" name="duration" value="<?php echo $duration; ?>">
        </div>
        <div class="form-group">
            <label for="size">Size(GB)</label>
            <input class="form-control" id="size" type="text" name="size" value="<?php echo $size; ?>">
        </div>
        <div class="form-group">
            <label for="genre">Genre</label>
            <input class="form-control" id="genre" placeholder="action,drama" type="text" name="genre"
                   value="<?php echo $genre; ?>">
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input class="form-control" id="date" placeholder="release date" type="date" name="date" value="<?php echo $release_date; ?>">
        </div>
        <div class="form-group">
            <label for="pimage">Poster Image</label>
            <input class="form-control" id="pimage" type="file" name="pimage" value="<?php echo $poster_image;?>">
        </div>
        <?php
        if ($update == true):
            ?>
            <button type="submit" class="btn btn-warning btn-block btn-lg" name="update">Update</button>
        <?php else: ?>
            <button type="submit" name="save" class="btn btn-primary btn-block btn-lg">Submit</button>
        <?php endif; ?>
    </form>


</div>


</body>
</html>




































