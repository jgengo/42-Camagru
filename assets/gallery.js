var dlists = document.querySelectorAll(".delete"), 
    doSomething = function() {
        this.parentNode.style.display = 'none';

        var http = new XMLHttpRequest();
        var params = "id="+this.getAttribute('data-id');
        http.open("POST", "functions/delete_pic.php");
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.onreadystatechange = function() {
            if (http.readyState == 4 && http.status == 200) {
                // alert(http.responseText);
            }
        }
        http.send(params);
    };
[].map.call(dlists, function(elem) {
    elem.addEventListener("click", doSomething, false);
});
var olists = document.querySelectorAll(".vignette"), 
    doSomething = function() { this.childNodes[3].style.display = 'block'; this.childNodes[5].style.display = 'block'; this.childNodes[7].style.display = 'block'; this.childNodes[9].style.display = 'block'; if (this.childNodes.length > 11) { this.childNodes[11].style.display = 'block'; } };
    doSomethingElse = function() { this.childNodes[3].style.display = 'none'; this.childNodes[5].style.display = 'none'; this.childNodes[7].style.display = 'none'; this.childNodes[9].style.display = 'none'; if (this.childNodes.length > 11) { this.childNodes[11].style.display = 'none'; } };
[].map.call(olists, function(elem) {
    elem.addEventListener("mouseenter", doSomething, false);
    elem.addEventListener("mouseleave", doSomethingElse, false);
});
var tlists = document.querySelectorAll(".mess"),
    doSomething = function() { window.location.href = "?p=gallery&id="+this.getAttribute('data-id'); };
[].map.call(tlists, function(elem) {
    elem.addEventListener("click", doSomething, false);
}); 
var tlists = document.querySelectorAll(".thumb"),
    doSomething = function() {
        var http = new XMLHttpRequest();
        var params = "id="+this.getAttribute('data-id');
        http.open("POST", "functions/func_like.php");
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.onreadystatechange = function() {
            if (http.readyState == 4 && http.status == 200) {
                window.location.reload();
            }
        }
        http.send(params);
    };
[].map.call(tlists, function(elem) {
    elem.addEventListener("click", doSomething, false);
}); 