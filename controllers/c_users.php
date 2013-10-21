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
        # Generate and save a new token for the next Login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        #Send them back to the main index
        Router::redirect("/");


    }

    public function profile($user_name = NULL, $error = NULL) {

        #If user is blank, they're not logged in; redirect them to the Login page
        if (!$this->user) {
            Router::redirect('/users/login');
        }

        # If they weren't redirected away, continue:

        # Setup view
        $this->template->content = View::instance('v_users_profile');
        $this->template->title = "Profile of ".$this->user->first_name;

        # Set up error
        $this->template->content->error = $error;

        $this->template->content->user_name = $user_name;

        #Create array of CSS files
        $client_files_head = Array (
            '../css/profile.css',
            '../../css/profile.css',
            '../../css/error.css'
            );

        #Use Load client_files to generate the links from the above array
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

        echo $this->template;

        
    }

    public function upload_image() {

        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 20000)
        && in_array($extension, $allowedExts)) {

            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            }

            else {
    
                if (file_exists("images/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";

                    Router::redirect("/users/profile");
                } 
                else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                    "images/" . $_FILES["file"]["name"]);
                    echo "Stored in: " . "images/" . $_FILES["file"]["name"];


                    $data = Array("image_location" => "images/" . $_FILES["file"]["name"]);
                    DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");

                    Router::redirect('/users/profile');
                }
            }
        }
        else {
            Router::redirect("/users/profile/error");
        }
    }
} # end of the class