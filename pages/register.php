<?php if (!is_logged()) { ?>

<script>
function registerjs() {
  'use strict';
  var form = document.getElementById('reg_form');
  var request = new XMLHttpRequest();
  var post = "login=" + encodeURIComponent(form.login.value) + "&email=" + encodeURIComponent(form.email.value) + "&password=" + encodeURIComponent(form.password.value) + "&password_check=" + encodeURIComponent(form.password_check.value);

  request.onreadystatechange = function() {
    console.log("readyState: "+request.readyState+" status:"+request.status);
    if (request.readyState === XMLHttpRequest.DONE) {
      if (request.status == 200) {
        alert(request.responseText);
      }
    }
  }
  request.open('POST', 'functions/func_register.php', true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader("Access-Control-Allow-Origin","*")
  request.send(post);
};
</script>

<h2 id='page_title'>Register</h2>

<!-- <form method='post' onsubmit='registerjs()' id='reg_form'> -->
<form method='post' action="functions/func_register.php">

<label>login*</label>
<input type='text' placeholder="eg: jgengo" name='login' />
<label>email*</label>
<input type='email' placeholder="eg: jgengo@student.42.fr" name='email' />
<label>password*</label>
<input type='password' placeholder="*******" name='password' />
<label>confirm password*</label>
<input type="password" placeholder="*******" name='password_check' />
<input type='submit' value='Confirm' id='reg_submit'/>
</form>

<?php } else { ?>

<h2 id='page_title'>// Error</h2>

<label>You're already logged in, you're not supposed to be here...</label>

<?php } ?>