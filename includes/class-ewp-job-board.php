<?php
if (!class_exists('EWP_Job_Board')) {
    class EWP_Job_Board {
        public function __construct() {
            add_action('init', [$this, 'register_job_post_type']);
            add_action('init', [$this, 'register_job_category_taxonomies']);
            add_action('init', [$this, 'register_job_type_taxonomies']);
            add_action('add_meta_boxes', [$this, 'add_job_meta_boxes']);
            add_action('save_post', [$this, 'save_job_meta']);
        }

        public function register_job_post_type() {
            $labels = [
                'name' => 'Jobs',
                'singular_name' => 'Job',
                'menu_name' => 'Jobs',
                'name_admin_bar' => 'Job',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Job',
                'new_item' => 'New Job',
                'edit_item' => 'Edit Job',
                'view_item' => 'View Job',
                'all_items' => 'All Jobs',
                'search_items' => 'Search Jobs',
                'not_found' => 'No jobs found.',
                'not_found_in_trash' => 'No jobs found in Trash.',
            ];

            $args = [
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_icon' => 'dashicons-businessman',
                'query_var' => true,
                'rewrite' => ['slug' => 'job'],
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => ['title', 'editor', 'thumbnail'],
            ];

            register_post_type('job', $args);
        }

        public function register_job_category_taxonomies() {
            $labels = [
                'name' => 'Job Categories',
                'singular_name' => 'Job Category',
                'search_items' => 'Search Job Categories',
                'all_items' => 'All Job Categories',
                'parent_item' => 'Parent Job Category',
                'parent_item_colon' => 'Parent Job Category:',
                'edit_item' => 'Edit Job Category',
                'update_item' => 'Update Job Category',
                'add_new_item' => 'Add New Job Category',
                'new_item_name' => 'New Job Category Name',
                'menu_name' => 'Job Categories',
            ];

            $args = [
                'labels' => $labels,
                'hierarchical' => true,
                'public' => true,
                'show_admin_column' => true,
                'rewrite' => ['slug' => 'job-category'],
            ];

            register_taxonomy('job_category', ['job'], $args);
        }

        public function register_job_type_taxonomies() {
            $labels = [
                'name' => 'Job Types',
                'singular_name' => 'Job Type',
                'search_items' => 'Search Job Types',
                'all_items' => 'All Job Types',
                'parent_item' => 'Parent Job Type',
                'parent_item_colon' => 'Parent Job Type:',
                'edit_item' => 'Edit Job Type',
                'update_item' => 'Update Job Type',
                'add_new_item' => 'Add New Job Type',
                'new_item_name' => 'New Job Type Name',
                'menu_name' => 'Job Types',
            ];

            $args = [
                'labels' => $labels,
                'hierarchical' => true,
                'public' => true,
                'show_admin_column' => true,
                'rewrite' => ['slug' => 'job-type'],
            ];

            register_taxonomy('job_type', ['job'], $args);
        }

        public function add_job_meta_boxes() {
            add_meta_box(
                'job_details_meta_box', // ID
                'Job Details', // Title
                [$this, 'render_job_meta_box'], // Callback
                'job', // Post type
                'normal', // Context
                'high' // Priority
            );
        }

        public function render_job_meta_box($post) {
            // Add nonce for security and authentication
            wp_nonce_field('job_details_nonce_action', 'job_details_nonce');

            // Retrieve existing values from the database
            $salary = get_post_meta($post->ID, '_job_salary', true);
            $location = get_post_meta($post->ID, '_job_location', true);

            // Display the form fields
            echo '<label for="job_salary">Salary:</label>';
            echo '<input type="text" id="job_salary" name="job_salary" value="' . esc_attr($salary) . '" size="25" />';
            echo '<br><br>';
            echo '<label for="job_location">Location:</label>';
            echo '<input type="text" id="job_location" name="job_location" value="' . esc_attr($location) . '" size="25" />';
        }

        public function save_job_meta($post_id) {
            // Check if nonce is set
            if (!isset($_POST['job_details_nonce'])) {
                return $post_id;
            }

            $nonce = $_POST['job_details_nonce'];

            // Verify that the nonce is valid
            if (!wp_verify_nonce($nonce, 'job_details_nonce_action')) {
                return $post_id;
            }

            // Check if the user has permission to save the data
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            // Sanitize and save the data
            $salary = sanitize_text_field($_POST['job_salary']);
            $location = sanitize_text_field($_POST['job_location']);

            update_post_meta($post_id, '_job_salary', $salary);
            update_post_meta($post_id, '_job_location', $location);
        }
    }
}