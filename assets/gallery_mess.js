var objDiv = document.getElementById("comment_box");
var messbox = document.getElementById("comment_write");
var charbox = document.getElementById("count_box");
var count = 100;
window.onload = function() {
    messbox.focus();
}
messbox.addEventListener('keyup', function (e) {
    var key = e.which || e.keyCode;
    var aff_count = count - messbox.value.length;
    if (aff_count < 0)
        charbox.style.color = "red";
    if (aff_count >= 0)
        charbox.style.color = "#baa";
    charbox.innerHTML = aff_count+" character"+((aff_count != 1 && aff_count != -1) ? "s" : "")+" left";

    if (key === 13) {
        if (aff_count < 0)
            alert("too big!");
        else if (aff_count == 100)
            alert("nothing?");
        else
        {
            var http = new XMLHttpRequest();
            var params = "comm="+messbox.value;
            http.open("POST", "functions/add_comm.php");
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                    if (http.responseText != 'ok')
                        alert(http.responseText);
                    else
                        window.location.reload();

                }
            }
            http.send(params);
        }
    }
});
var dlists = document.querySelectorAll(".delete"), 
    doSomething = function() {
        this.parentNode.style.display = 'none';

        var http = new XMLHttpRequest();
        var params = "id="+this.getAttribute('data-id');
        http.open("POST", "functions/delete_comm.php");
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.onreadystatechange = function() {
            if (http.readyState == 4 && http.status == 200) {
                if (http.responseText != 'ok')
                    alert(http.responseText);
                else
                    messbox.focus();
            }
        }
        http.send(params);
    };
[].map.call(dlists, function(elem) {
    elem.addEventListener("click", doSomething, false);
});

objDiv.scrollTop = objDiv.scrollHeight;