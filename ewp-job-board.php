<?php
/**
 * Plugin Name: EWP Job Board
 * Description: A simple job board plugin for WordPress.
 * Version: 1.0.0
 * Author: Mahmud Imran
 * Author URI: https://github.com/mahmudimranemu
 */

if (!class_exists('EWP_Job_Board_Main')) {
    class EWP_Job_Board_Main {
        public function __construct() {
            // Load necessary classes
            $this->load_classes();
            
            // Initialize hooks and actions
            // add_action('init', [$this, 'register_post_type']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        }

        private function load_classes() {
            require_once plugin_dir_path(__FILE__) . 'includes/class-ewp-job-board.php';
            require_once plugin_dir_path(__FILE__) . 'includes/class-ewp-job-board-admin.php';

            // Instantiate the classes
            new EWP_Job_Board();
            new EWP_Job_Board_Admin();
        }

        // public function register_post_type() {
        //     // Register custom post type for job listings
        //     register_post_type('jobs', [
        //         'labels' => [
        //             'name' => __('Jobs '),
        //             'singular_name' => __('Job '),
        //         ],
        //         'public' => true,
        //         'has_archive' => true,
        //         'supports' => ['title', 'editor', 'thumbnail'],
        //     ]);
        // }

        public function enqueue_admin_scripts() {
            // Enqueue admin styles and scripts
            wp_enqueue_style('ewp-job-board-admin-css', plugin_dir_url(__FILE__) . 'assets/css/admin.css');
            wp_enqueue_script('ewp-job-board-admin-js', plugin_dir_url(__FILE__) . 'assets/js/admin.js', ['jquery'], null, true);
        }
    }

    new EWP_Job_Board_Main();
}