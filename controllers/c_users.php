<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        echo "users_controller construct called<br><br>";
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
        echo "This is the signup page";

        #Setup view
        $this->template->content = View::instance('v_users_signup');

        #Set page title
        $this->template->title   = "Sign Up";

        #Create array of CSS files
        $client_files_head = Array (
            '../css/signup.css'
            );

        #Use Load client_files to generate the links from the above array
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

        #Render template
        echo $this->template;
    }

    public function p_signup() {

        # Dump out the results of POST to see what the form submitted
        //print_r($_POST);

        # More data we want stored with the user
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        # Encrypt the password
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Create an encrypted token via thier email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # For now, just confirm they've signed up -

        echo "You're signed up";

        Router::redirect('/users/login');
    }

    public function login($error = NULL) {
        echo "This is the login page";

        # Setup View
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";

        # Set up error
        $this->template->content->error = $error;

        #Create array of CSS files
        $client_files_head = Array (
            '../css/login.css',
            '../../css/login.css',
            '../../css/error.css'
            );

        #Use Load client_files to generate the links from the above array
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

        # Render template
        echo $this->template;
    }

    public function p_login() {

        #Sanitize the user entered date
        $POST = DB::instance(DB_NAME)->sanitize($_POST);

        #Has submitted password
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the DB for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token 
        FROM users 
        WHERE email = '".$_POST['email']."' 
        AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q); 

        # IF we didn't find a matching toek in database, failed
        if(!$token) {

            Router::redirect("/users/login/error");

            # Send them back to the login poage
            Router::redirect("/users/login");

        # But if we did
        } else {

            setcookie("token", $token, strtotime('+1 year'), '/');

            # Send them to the main page

            Router::redirect("profile");
        }

    }

    public function logout() {
        echo "This is the logout page";

    }

    public function profile($user_name = NULL) {

        $this->template->content = View::instance('v_users_profile');
        $this->template->title = "Profile";

        $this->template->content->user_name = $user_name;

        echo $this->template;

        
    }

} # end of the class