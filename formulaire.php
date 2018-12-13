<?php
// Self-explanatory
function sanitize($data) {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    return $data;
}

$newTask = trim($_POST["task"]);
$err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($newTask)) { /* If page is called with post (means form was submitted)
                                                                    and trimmed input isn't empty */
    $newTask = sanitize($_POST["task"]); // Sanitizing form input
    $file = 'todo.json';
    $json = file_get_contents($file); // Self-explanatory
    $content = json_decode($json); // Decodes json into php array
    $task = ["task" => $newTask]; // Prepares new object
    array_push($content, $task); // Puts new object into php array decoded from json
    $json = json_encode($content); // Encodes php array into json
    file_put_contents($file, $json); // writes file with latest json
} else {
    $err = 'placeholder="Vous devez entrer une tâche"';
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>"You can be do what we want ToDo"</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="addTaskForm">
        <h2>Ajouter une tâche</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="newTask">Nouvelle tâche :</label>
            <input class="input" type="text" id="newTask" name="task" <?php echo $err?>>
            <button type="submit">Ajouter</button>
        </form>
    </div>

</body>
</html>