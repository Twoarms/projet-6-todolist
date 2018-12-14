<?php

$file = 'todo.json';
$json = file_get_contents($file);
$content = json_decode($json, true);
$changed = [];
if (isset($_POST["save"])) {
    if (isset($_POST["todo"])) {
        foreach($_POST["todo"] as $value) { // Pour chaque valeur des checkbox de nom todo
            foreach($content as $key => $task) { // Pour chaque objet du json en tant que tâche
                if ($task["id"] == $value) { // Si l'id de la tâche correspond a la valeur de checkbox
                    $content[$key]["status"] = 1; // Statut de la tache = 1 aka done
                    /* array_push($changed, $value); */ // Array avec id des objets dont statut a changé
                } /* elseif ($task["id"] != $value && !in_array($task["id"], $changed)) { // Si l'id correspond pas et ne fait pas partie des objets modifiés cette fois
                    $task["status"] = 0; // statut tache = 0 aka à faire
                } */
            }
        }
        $json = json_encode($content);
        file_put_contents($file, $json);
    } /* elseif (!isset($_POST["todo"])) { // Si aucune checkbox checked
        foreach ($content as &$task) { // Pour chaque tâche
            $task["status"] = 0; // Statut tache = 0
        }
    } */
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
                        echo '<li><label><input type="checkbox" checked name="" value="'.$task["id"].'" id="'.$task["id"].'">&nbsp;<del>'.$task["task"].'</del></label></li>';
                    }
                }
                ?>
                </ul>
            </fieldset>

                <button type="submit" name="save">Enregistrer</button>
        </form>

    </div>