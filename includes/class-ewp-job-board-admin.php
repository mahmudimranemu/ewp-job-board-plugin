<?php
if (!class_exists('EWP_Job_Board_Admin')) {
    class EWP_Job_Board_Admin {
        public function __construct() {
            add_action('admin_menu', [$this, 'ewp_job_board_admin_menu']);
        }

        public function ewp_job_board_admin_menu() {
            add_menu_page(
                'Manage EWP Job Board', // Page title
                'EWP Job Settings', // Menu title
                'manage_options', // Capability
                'ewp-job-settings', // Menu slug
                [$this, 'ewp_job_settings_page'], // Function to display the page content
                'dashicons-businessman', // Icon URL or Dashicon class
                6 // Position
            );
        }

        public function ewp_job_settings_page() {
            ?>
            <div class="wrap">
                <h1>Manage Job Listings</h1>
                <p>Here you can manage your job listings.</p>
                <!-- Additional admin interface elements will go here -->
            </div>
            <?php
        }
    }
}