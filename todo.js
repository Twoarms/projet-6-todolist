const save = document.getElementById("save");
save.hidden = true;

let form = document.getElementById('tdl');

let changeTaskStatus = () => {
    let xhttp = new XMLHttpRequest();
    let FD = new FormData(form);
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log('update');
        }
    }
    xhttp.open("POST", 'contenu.php', true);
    xhttp.send(FD);
    save.click();
}


let task = document.querySelectorAll(".task");

Array.from(task).forEach(addEventListener('change', function () {
        changeTaskStatus();
}));
    
form.addEventListener("submit", function (event) {
    event.preventDefault();
});