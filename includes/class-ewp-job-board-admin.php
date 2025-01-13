<?php
class EWP_Job_Board_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'ewp_job_board_admin_menu']);
    }

    public function ewp_job_board_admin_menu() {
        add_submenu_page(
            'ewp-job-board', // Parent slug
            'Manage Job Listings', // Page title
            'Job Listings', // Menu title
            'manage_options', // Capability
            'ewp-job-listings', // Menu slug
            [$this, 'ewp_job_listings_page'] // Function to display the page content
        );
    }

    public function ewp_job_listings_page() {
        ?>
        <div class="wrap">
            <h1>Manage Job Listings</h1>
            <p>Here you can manage your job listings.</p>
            <!-- Additional admin interface elements will go here -->
        </div>
        <?php
    }
}