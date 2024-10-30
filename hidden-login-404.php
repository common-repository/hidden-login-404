<?php
/*
* Plugin Name: Hidden Login 404
* Description: Hides the login page
* Version: 1.0.1
* Author: petrozavodsky
* Author URI: http://alkoweb.ru/
* Plugin URI: http://alkoweb.ru/hidden-login
* Text Domain: hidden_login_404
* Domain Path: /languages/
*/
define('hidden_login_404_DIR', plugin_dir_path(__FILE__));
define('hidden_login_404_URL', plugin_dir_url(__FILE__));

add_action('plugins_loaded', 'hidden_login_404_textdomain');

function hidden_login_404_textdomain()
{
    load_plugin_textdomain(
        'hidden_login_404',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages/'
    );
}

if (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache')) {

    require_once(ABSPATH . "wp-includes/pluggable.php");

    register_activation_hook(__FILE__, 'hidden_login_404_activation');
    register_deactivation_hook(__FILE__, 'hidden_login_404_deactivation');

    function hidden_login_404_functions_add_hidde_add($rules)
    {

        if (!is_plugin_active(hidden_login_404_DIR . 'hidden-login.php')) {
            $rules = "\r\n<IfModule mod_rewrite.c> \r\nRewriteEngine On \r\nRewriteRule ^su.php$ wp-login.php [L] \r\n</IfModule>\r\n\r\n" . $rules;
        }

        return $rules;
    }

    function hidden_login_404_functions_add_hidde_remove($rules)
    {
        return $rules;
    }

    function hidden_login_404_activation($rules)
    {
        global $wp_rewrite;
        add_filter('mod_rewrite_rules', 'hidden_login_404_functions_add_hidde_add');
        $wp_rewrite->flush_rules();
    }


    function hidden_login_404_deactivation()
    {
        global $wp_rewrite;
        add_filter('mod_rewrite_rules', 'hidden_login_404_functions_add_hidde_remove');
        $wp_rewrite->flush_rules();
    }

    function hidden_login_404_page_jquery_scripts()
    {
        wp_enqueue_script('jquery');
    }

    add_action('login_enqueue_scripts', 'hidden_login_404_page_jquery_scripts');

    function hidden_login_404_add_js()
    {
        $request_url_login = basename($_SERVER['REQUEST_URI']);

        if ('su.php' == $request_url_login || 'rp' == $_GET['action']) {
            echo '<script>jQuery(document).ready(function($) { 
                    $("#nav a").attr("href","su.php?action=lostpassword"); 
                    $("#loginform").attr("action","su.php"); 
                    });</script>';
        }

        if ($request_url_login == 'su.php?action=lostpassword') {
            echo '<script>jQuery(document).ready(function($) { 
                        $("#nav a").attr("href","su.php"); 
                        $("#lostpasswordform").attr("action","su.php?action=lostpassword"); 
                    });</script>';
        }
        if ($_GET['action'] == 'resetpass') {
            echo '<script>jQuery(document).ready(function($) { 
                    $(".reset-pass a").attr("href","su.php"); 
                    });</script>';
        }
    }

    add_action('login_head', 'hidden_login_404_add_js');


    function hidden_login_404_payload()
    {

        if (basename($_SERVER['REQUEST_URI']) == 'wp-login.php?checkemail=confirm') {
            function hide_login_checkemail()
            {
                wp_redirect('su.php?checkemail=confirm', 301);
            }

            add_action('login_init', 'hide_login_checkemail');
        }

        if ($_GET['action'] !== 'rp') {
            if ($_GET['action'] !== 'resetpass') {
                $book_collection[] = 'su.php?action=lostpassword';
                $book_collection[] = 'su.php?checkemail=confirm';
                $book_collection[] = 'wp-login.php?checkemail=confirm';
                $book_collection[] = 'su.php';
                $book_collection = array_flip($book_collection);
                $book = basename($_SERVER['REQUEST_URI']);

                if (!isset($book_collection[$book])) {
                    function hide_login()
                    {
                        wp_redirect('404.php', 301);
                    }

                    add_action('login_init', 'hide_login');
                }
            }
        }

        if (basename($_SERVER['REQUEST_URI']) == 'su.php') {
            if (is_user_logged_in()) {
                wp_redirect('wp-admin', 301);
            }
        }

    }

    add_action("plugins_loaded", 'hidden_login_404_payload');

    function hidden_login_404_custom_loginout_default_page($logout_url, $redirect)
    {
        $go_to_url = site_url('su.php');

        if (empty($redirect)) {
            $logout_url = add_query_arg('redirect_to', urlencode($go_to_url), $logout_url);
        }

        return $logout_url;
    }

    add_filter('logout_url', 'hidden_login_404_custom_loginout_default_page', 10, 2);

} else {

    function hidden_login_404_admin_notice()
    {
        global $pagenow;

        if ("plugins.php" == $pagenow) ;
        {
            ?>
            <div class="notice notice-info is-dismissible">
                <p> <?php _e('The plugin works only with apache. Now the plugin does nothing. It can be disabled.', 'hidden_login_404'); ?> </p>
            </div>
            <?php
        }

    }

    add_action('admin_notices', 'hidden_login_404_admin_notice');


}

