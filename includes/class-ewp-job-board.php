class EWP_Job_Board {
    public function __construct() {
        add_action('init', [$this, 'register_job_post_type']);
        add_action('init', [$this, 'register_job_taxonomies']);
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
            'query_var' => true,
            'rewrite' => ['slug' => 'job'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'supports' => ['title', 'editor', 'thumbnail'],
        ];

        register_post_type('job', $args);
    }

    public function register_job_taxonomies() {
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
}