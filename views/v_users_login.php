<div id="login">

<form method='POST' action='/users/p_login'>

    Email<br>
    <input type='text' name='email'>

    <br><br>

    Password<br>
    <input type='password' name='password'>

    <br><br>

    <input type='submit' value='Log in'>

    <?php if(isset($error)): ?>
        <div class='error'>
        </br>
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>

</form>

</div>