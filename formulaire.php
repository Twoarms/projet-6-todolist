<?php
// Self-explanatory
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    return $data;
}

/* $newTask = trim($_POST["task"]); */
$err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && !empty(trim($_POST["task"]))/*  && empty($_POST["save"]) */) { /* If form is submitted,
trimmed input isn't empty and page was not reloaded by "save" submit */
    $newTask = sanitize($_POST["task"]); // Sanitizing form input
    $file = 'todo.json';
    $json = file_get_contents($file); // Self-explanatory
    $content = json_decode($json, true); // Decodes json into php array
    $task = ["task" => $newTask, "status" => 0, "id" => 'whatevIllGetReplaced']; // Prepares new object
    array_push($content, $task); // Puts new object into php array decoded from json
    $id = 0;
    foreach($content as &$object) {
        $object["id"] = $id;
        $id++;
    }
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

    <?php require('contenu.php'); ?>

    <div class="addTaskForm">
        <h2>Ajouter une tâche</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="newTask">Nouvelle tâche :</label>
            <input class="input" type="text" id="newTask" name="task" <?php echo $err;?> required>
            <button type="submit" name="submit">Ajouter</button>
        </form>
    </div>

</body>
</html>