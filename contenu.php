<?php

$file = 'todo.json';
$json = file_get_contents($file);
$content = json_decode($json, true);
?>

    <div class="toDoList">
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <fieldset>
                <legend>Tout doux :</legend>
                <?php
                foreach($content as $task) {
                    if ($task["status"] == 0) {
                        echo '<label><input type="checkbox">'.$task["task"].'</label>';
                    }
                };
                ?>
            </fieldset>

            <fieldset>
                <legend>Art cave :</legend>
                <?php
                foreach($content as $task) {
                    if ($task["status"] == 1) {
                        echo '<label><input type="checkbox">'.$task["task"].'</label>';
                    }
                }
                ?>
            </fieldset>

        </form>

    </div>