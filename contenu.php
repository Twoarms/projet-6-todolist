<?php

$file = 'todo.json';
$json = file_get_contents($file);
$content = json_decode($json, true);
if (isset($_POST["save"])) {
    if (isset($_POST["todo"]) && isset($_POST["done"])) {
        foreach ($content as $key => $task) {
            if (!in_array($task["id"], $_POST["done"])) {
                $content[$key]["status"] = 0;
            }
            foreach ($_POST["todo"] as $value) {
                if ($task["id"] == $value) {
                    $content[$key]["status"] = 1;
                }
            }
        }
    } else if (isset($_POST["todo"])) {
        foreach($_POST["todo"] as $value) { // Pour chaque valeur des checkbox de nom todo
            foreach($content as $key => $task) { // Pour chaque objet du json en tant que tâche
                if ($task["id"] == $value) { // Si l'id de la tâche correspond a la valeur de checkbox
                    $content[$key]["status"] = 1; // Statut de la tache = 1 aka done
                }
            }
        }
    } else if (isset($_POST["done"])) {
        foreach($content as $key => $task) {
            if (!in_array($task["id"], $_POST["done"])) {
                $content[$key]["status"] = 0;
            }
        }
    } else if (!isset($_POST["done"])) {
        foreach($content as $key => $task) {
            if ($task["status"] == 1) {
                $content[$key]["status"] = 0;
            }
        }
/*     } else if (!isset($_POST["done"]) && isset($_POST["todo"])) {
        foreach($content as $key => $task) {
            foreach ($_POST["todo"] as $value) {
                if ($task["id"] == $value) {
                    $content[$key]["status"] = 1;                            Ce bout de code ne fonctionne pas
                }
            }
            if ($task["status"] == 1) {
                $content[$key]["status"] = 0;
            }
        } */
    }
    $json = json_encode($content);
    file_put_contents($file, $json);
}

?>

    <div class="toDoList">
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

            <fieldset>
                <legend>Tout doux :</legend>
                <ul>
                <?php
                foreach($content as $task) {
                    if ($task["status"] == 0) {
                        echo '<li><label><input type="checkbox" name="todo[]" value="'.$task["id"].'" id="'.$task["id"].'">&nbsp;'.$task["task"].'</label></li>';
                    }
                };
                ?>
                </ul>
            </fieldset>


            <fieldset>
                <legend>Art cave :</legend>
                <ul>
                <?php
                foreach($content as $task) {
                    if ($task["status"] == 1) {
                        echo '<li><label><input type="checkbox" checked name="done[]" value="'.$task["id"].'" id="'.$task["id"].'">&nbsp;<del>'.$task["task"].'</del></label></li>';
                    }
                }
                ?>
                </ul>
            </fieldset>

                <button type="submit" name="save">Enregistrer</button>
        </form>

    </div>