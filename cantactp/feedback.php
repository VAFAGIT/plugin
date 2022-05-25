<?php
/*
Plugin Name: feedback 
Plugin URI: https://wordpress.com
Description: feedback form for rating
Version: 1.0
Author: Mehdi Lagdimi
Author URI: https://wordpress.com
*/

if( !defined('ABSPATH'))
{
    die;
}

class feedback{

    public function __construct()
    {
        //Create custom post type
        add_action('init', array($this, 'create_custom_post_type'));   
        
        
        //Add shortcode
        add_shortcode('feedback-form', array($this, 'load_shortcode'));

        //Add assets (js, css, etc)
        // add_action('wp_enqueue_scripts', array($this, 'load_assets'));
    }

    public function create_custom_post_type()
    {
        $args= array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title'),
            'exlude_from_search' => true,
            'publicly_queryable' => false,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'Feedback Form',
                'singular_name' => 'Feedback Form Entry'
            ),
            'menu_icon' => 'dashicons-media-text'
        );

        register_post_type('simple_feedback_form', $args);
    }

    // public function load_assets()
    // {
    //     wp_enqueue_style(
    //         'simple-feedback-form',
    //         plugin_dir_url(__FILE__) . 'css/feedback.css',
    //         array(), 
    //         1, 
    //         'all'
    //     );
    // }

    public function load_shortcode()
    {?>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <div style="background-image:url('https://i.pinimg.com/564x/d9/d3/61/d9d361878bfcfa801a96ae9f466fbe11.jpg')  ;" class="bg-no-repeat bg-cover object-cover h-2/4 w-2/4 m-auto rounded-lg p-5"> -->
    <h1 style="text-align:center" class="text-lg text-5xl text-black content-center m-4"> Feedback Form</h1>
    <div class="m-auto w-2/6 bg-black p-4 rounded-md shadow-lg">
        <!-- <h3>Please help us to serve you better by taking a couple of minutes. </h3>
        <form action="http://localhost/wordpress/e-commerce/thank-you/" method="POST" class="agile_form"> -->
        <form action="" method="POST" class="agile_form">
            <h2 class="mb-7 text-2xl text-white font-bold">How satisfied were you with our Service?</h2>
            <ul class="">
            <li>
                <input class="ml-2 mb-3" type="radio" name="opinion" value="very satisfied" id="very satisfied" required> 
                <label class="text-white " for="very satisfied">1</label>
                <div class="check w3"></div>
            </li>
            <li>
                <input class="ml-2 mb-3" type="radio" name="opinion" value="satisfied" id="satisfied"> 
                <label class="text-white " for="satisfied">2</label>
                <div class=""></div>
            </li>
            <li>
                <input class="ml-2 mb-3" type="radio" name="opinion" value="neutral" id="neutral">
                <label class="text-white " for="neutral">3</label>
                <div class=""></div>
            </li>
            <li>
                <input class="ml-2 mb-3" type="radio" name="opinion" value="unsatisfied" id="unsatisfied"> 
                <label class="text-white " for="unsatisfied">4</label>
                <div class=""></div>

            <li>
                <input class="ml-2 mb-3" type="radio" name="opinion" value="very unsatisfied" id="very unsatisfied"> 
                <label class="text-white " for="very unsatisfied">5</label>
                <div class=""></div>
            </li>
            </ul>
            <h2 class="mt-7 mb-5 text-white text-lg font-medium">Please write to us if you would like to add something</h2>
            <div><textarea placeholder="Additional comments" class="h-24 w-full rounded-lg p-4 shadow text-sm" name="feedback" required=""></textarea></div>
            <h2 class="mt-7 mb-1 text-white text-lg font-normal">Optional information :</h2>
            <div><input class="h-10 w-full rounded-lg mt-3 p-4 shadow text-sm" type="text" placeholder="Your Name" name="name"/></div>
            <div><input class="h-10 w-full rounded-lg mt-3 p-4 shadow text-sm" type="email" placeholder="Your Email" name="email"/></div>
            <!-- <div><input class="h-10 w-full rounded-lg mt-3 p-4 shadow text-sm" type="text" placeholder="Your Number" name="num"/></div> -->
            <div><input type="hidden" name="id" value="<?php echo get_the_ID() ?> "></div>
            <div class="md:flex md:justify-center mt-10"><button type="submit" name="submit" class="bg-white text-black m-auto shadow rounded-lg text-center font-bold font-sans border-none hover:bg-blue-500 px-10 py-6">SUBMIT</button></div>
        </form>
    </div>
</div>

    <?php }
}

new feedback;

global $wpdb;
if (isset($_POST['submit'])) {
   $feedback = $_POST['feedback'];
   $name = $_POST['name'];
   $email = $_POST['email'];
//    $num = $_POST['num'];
   $id = $_POST['id'];
   $opinion = $_POST['opinion'];
   
   $wpdb->insert('wp_feedback', array('feedback' => $feedback, 'name' => $name, 'email' => $email, 'opinion' => $opinion, 'post_id' => $id));
   echo " <script> alert('thank you') </script>";
   header('refresh:0', 'Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
}