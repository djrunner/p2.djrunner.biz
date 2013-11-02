<?php

class posts_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();

		# Make sure user is logged in if they want to use anything in this controller

		if(!$this->user) {
			Router::redirect('users/login');
		}

	}

	public function add() {

		# Set up view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title   = "New Post";

		# Render template
		echo $this->template;

	}

	public function p_add() {

		# Associate this post with this user
		$_POST['user_id'] = $this->user->user_id;

		# Unix timestamp of when this post was created / modifed
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		# Insert
		DB::instance(DB_NAME)->insert('posts', $_POST);

		# Send user to list of posts
        Router::redirect('/posts/index');
	
	}

    public function p_delete($post_id_to_delete) {

        DB::instance(DB_NAME)->delete('posts', "WHERE post_id = '$post_id_to_delete'");

        Router::redirect('/posts/index');
    }

	public function index() {

    # Set up the View
    $this->template->content = View::instance('v_posts_index');
    $this->template->title   = "Posts";

    # Build the query
    $q = 'SELECT 
            posts.content,
            posts.created,
            posts.user_id AS post_user_id,
            users_users.user_id AS follower_id,
            users.first_name,
            users.last_name,
            users.image_location,
            posts.post_id AS post_id
        FROM posts
        INNER JOIN users_users 
            ON posts.user_id = users_users.user_id_followed
        INNER JOIN users 
            ON posts.user_id = users.user_id
        WHERE users_users.user_id = '.$this->user->user_id;



    # Run the query
    $posts = DB::instance(DB_NAME)->select_rows($q);

    # Pass data to the View
    $this->template->content->posts = $posts;

    #Create array of CSS files
        $client_files_head = Array (
            '../css/css.css'
            );

        #Use Load client_files to generate the links from the above array
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

    # Render the View
    echo $this->template;

    }

    public function users() {

    	# Set up the view
    	$this->template->content = View::instance('/v_posts_users');
    	$this->template->title   = "Users";

    	# Build the query to get all the users
    	$q = "SELECT *
    		From users
            WHERE user_id != ".$this->user->user_id;

    	# Execute the query to get all the users.
    	# Store the result array in the variable $users
    	$users = DB::instance(DB_NAME)->select_rows($q);

    	# Build the querry to figure out what connections does this user already have?
    	# ie who are they following?
    	$q = "SELECT *
    		FROM users_users
    		WHERE user_id = ".$this->user->user_id;

        $current_user = $this->user->user_id;

    	# Execute this query with the select_array method
    	# select_array will return our results in an array and use the "user_id_followed" field as the index.
    	# This will come in handy when we get to the view
    	# Store our results (an array) in the variable $connections
    	$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

    	# Pass data (users and connections) to the view
    	$this->template->content->users        = $users;
    	$this->template->content->connections  = $connections;
        $this->template->content->current_user = $current_user;

        #Create array of CSS files
        $client_files_head = Array (
            '../css/css.css'
            );

        #Use Load client_files to generate the links from the above array
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

    	# Render the view
    	echo $this->template;

    }

    public function follow($user_id_followed) {

    	# Prepare the data array to be inserted
    	$data = Array(
    		"created"          => Time::now(),
    		"user_id"          => $this->user->user_id,
    		"user_id_followed" => $user_id_followed
			);

    	DB::instance(DB_NAME)->insert('users_users', $data);

    	# Send them back
    	Router::redirect('/posts/users');
	}

	public function unfollow($user_id_followed) {

		# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);

		# Send them back
		Router::redirect('/posts/users');
	}

}	# End of class