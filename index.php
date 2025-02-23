<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do list || Oneyes task 3</title>
    <!-- external css files links-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "todolist_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["title"])) {
            $title = $_POST["title"];
            $sql = "INSERT INTO tasks (title) VALUES ('$title')";
            $conn->query($sql);
        }

        if (isset($_POST["delete"])) {
            $id = $_POST["delete"];
            $sql = "DELETE FROM tasks WHERE id=$id";
            $conn->query($sql);
        }
    }

    // Filter tasks based on the category
    $category = isset($_GET["category"]) ? $_GET["category"] : 'Pending';
    $sql = "SELECT * FROM tasks WHERE status='$category'";
    $result = $conn->query($sql);
    ?>
    <div class="wrapper">
        <div class="container">
            <div class="h2" id="main-heading">To do List</div>
            <div class="bgc-container">
                <div class="sub-container">
                    <form method="GET" action="">
                        <select name="category" id="category" onchange="this.form.submit()">
                            <option value="Pending" <?php echo $category == 'Pending' ? 'selected' : '' ?>>Tasks</option>
                            <option value="Completed" <?php echo $category == 'Completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </form>
                    <button class="add"><span>+</span> New</button>
                </div>
                <form action="" method="POST">
                    <div class="search-bar">
                        <input type="text" name="title" id="title" class="title" placeholder="add title">                       
                        <button class="save-btn" id="save-btn">Save</button>
                    </div>
                </form>
    
                <div class="task-containers">
                    <ul>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<li>
                                        <input type='checkbox' class='checkbox' " . ($row["status"] == 'Completed' ? 'checked' : '') . ">
                                        <p class='task-title'>" . $row["title"] . "</p>
                                        <div class='sub-tools'>
                                            <form method='POST' style='display:inline;'>
                                                <button class='delete' name='delete' value='" . $row["id"] . "'><i class='fa-solid fa-trash'></i></button>
                                            </form>
                                        </div>
                                      </li>";
                            }
                        } else {
                            echo "<li>No tasks found</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    $conn->close();
    ?>
</body>
</html>
