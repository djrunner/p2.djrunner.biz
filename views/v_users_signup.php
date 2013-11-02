<div class="mainBox" id="users_signUp">

<form method='POST' action='/users/p_signup'>

    First Name<br>
    <input type='text' name='first_name'>
    <br><br>

    Last Name<br>
    <input type='text' name='last_name'>
    <br><br>

    Email<br>
    <input type='text' name='email'>
    <br><br>

    Password<br>
    <input type='password' name='password'>
    <br><br>

    <input type='submit' value='Sign Up'>

    <?php if(isset($error)): ?>
        <div class='error'>
        <br>
            Please do not enter a blank field.
        </div>
        <br>
    <?php endif; ?>

</form>

</div>