<?php 

include 'db.php';
    $status = '';

    if (isset($_POST['submit'])){

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO task_info (task) VALUES (?)");
    $stmt->bind_param("s", $task);
    
    // Set parameter and execute the statement
    $task = $_POST['task'];
    $stmt->execute();
    
    // Close the statement
    $stmt->close();


        if (mysqli_query($conn, $sql)){
            $status = "Added to list successfully!";
            header('Location: index.php');
        } else {
            $status = 'query error' . mysqli_error($conn);
        }

    }

    if (isset($_POST['delete'])){

    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM task_info WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Set parameter and execute the statement
    $id = $_POST['id_delete'];
    $stmt->execute();
    
    // Close the statement
    $stmt->close();
    
       
    
        if (mysqli_query($conn, $sql)){
            header('Location: index.php');
        } else {
            $status = 'query error' . mysqli_error($conn);
        }
    
    }

    $sql = 'SELECT id, task, date_created FROM task_info';

    $result = mysqli_query($conn, $sql);

    $usertask = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TODO List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-sm border mt-5 p-5 d-flex justify-content-center flex-column bg-info-subtle text-info-emphasis shadow rounded">
            <h2>TODO List</h2>
            <form action="index.php" method="post">
                <input class="form-control" type="text" placeholder="What would you like to do?" name="task" autocomplete="off" required>
                <input class="btn btn-primary d-block mt-2 mx-auto" type="submit" name="submit" value="Add to list">
            </form>
            <p class="fs-4 fw-light text-center mt-2 text-success"><?php echo $status ?></p>
        </div>

        <div class="container-sm border mt-3 d-flex justify-content-center flex-column bg-info-subtle text-info-emphasis shadow rounded">
            <div class="container d-flex align-items-start mt-3 mb-4">
                <h3>List</h3>
            </div>
                <?php foreach($usertask as $userts) :?>
                    <?php if($userts): ?>
                    <div class="container-md border border-dark p-2 mb-2 border-opacity-50 bg-primary-subtle text-primary-emphasis d-flex justify-content-between align-items-center text-wrap p-3 mt-2">
                        <h6><?php echo htmlspecialchars($userts['task']); ?></h6>
                        <h6><?php echo htmlspecialchars('Date Created: ' . $userts['date_created']); ?></h6>
                        <form action="index.php" method="post">
                            <input type="hidden" name="id_delete" value="<?php echo $userts['id']; ?>">
                            <input class="btn btn-danger" type="submit" name="delete" value="Delete"> 
                        </form>
                  
                    </div>
                    <?php else : ?>
                        <h2><?php echo "No data exist"; ?></h2>
                    <?php endif; ?>
                <?php endforeach;?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>