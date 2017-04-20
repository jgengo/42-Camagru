<aside>

<?php if (!is_logged()) { ?>
<h2 class='title'>Sign in</h2>
<form id="log_form" action='functions/func_login.php' method="post">
<input type='text' placeholder="login" size='30' name='login' class='test'/>
<input type='password' placeholder="password" name='password' size='30'/>
<input type='submit' value='Connect' id='signin' />
</form>
<div id='forgot'>
	<a href='?p=forgot'>Forgot Password</a>
</div>
<h2 class='title'>Register</h2>

<input id='register' type='submit' value='Join us' onClick="window.location.replace('?p=register');" />
<?php } else { ?>
<h2 class='title'>Stats</h2>
<?php $arr = stats_taken(); ?>
<div class='stats'>
	<p><span><?php echo $arr[0]; ?></span> photos taken</p>
	<p><span><?php echo $arr[1]; ?></span> comments written</p>
	<p><span><?php echo $arr[2]; ?></span> photos liked</p>
</div>
<input type='submit' value='Log out' id='logout' />
<div id='forgot'>
  <a href='?p=changepw'>Change Password</a>
</div>
<?php } ?>


<?php if (is_logged()) { ?>
<script>
(function() {
  'use strict';
  var btn = document.getElementById('logout');
  var request = new XMLHttpRequest();
  
  request.onreadystatechange = function() {
    if(request.readyState === XMLHttpRequest.DONE) {
      if(request.status === 200) {
        console.log(request.responseText);
      }      
    }
  }
  request.open('GET', 'functions/session_destroy.php');
  btn.addEventListener('click', function() {
    request.send();
    alert('You\'ve been delogged');
    window.location.replace(".");
  });
})();
</script>

<?php } else { ?>
<script>
function loginjs() {
  'use strict';
  var form = document.getElementById('log_form');
  var request = new XMLHttpRequest();
  
  request.onreadystatechange = function() {
    if(request.readyState === XMLHttpRequest.DONE) {
      if(request.status === 200) {
        if (request.responseText != 'ok')
        	alert(request.responseText);
      }      
    }
  }
  var post = "login=" + form.login.value + "&password=" + form.password.value;
  request.open('POST', 'functions/func_login.php');
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(post);
};
</script>
<?php } ?>

</aside>
