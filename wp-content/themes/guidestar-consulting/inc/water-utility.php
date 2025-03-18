<?php

class WaterUtility {

	private $translations;

    public function __construct() {
        add_action('init', [&$this, 'registerWaterUtilityPostType']);
        add_action('init', [&$this, 'registerTaxonomies']);
        add_action('init', [&$this, 'registerTaxonomyTerms']);

		// Admin Hooks
        add_action('add_meta_boxes', [&$this, 'addMetadataFields']);
        add_action('save_post', [&$this, 'saveMetadata']);
		add_action('rest_api_init', [&$this, 'register_rest_routes']);
		add_action('admin_enqueue_scripts', [&$this, 'enqueue_admin_styles']);

		// Frontend Hooks
		add_filter('pre_get_posts', [&$this, 'pre_get_posts']);
		add_filter('get_the_excerpt', [&$this, 'add_archive_map'], 30, 2);
		add_filter('get_the_date', [&$this, 'add_archive_last_updated'], 30, 3);

		// Shortcodes
		add_shortcode('utility-meta', [&$this, 'print_meta']);
		add_shortcode('utility-rating', [&$this, 'utility_rating']);
		add_shortcode('post-title', 'get_the_title');

		$this->translations = [
			'_federal_type' => [
				'C' => 'Community',
				'NTNC' => 'Non-Transient Non-Community',
				'NC' => 'Non-Community',
			],
			'_state_type' => [
				'C' => 'Community',
				'NTNC' => 'Non-Transient Non-Community',
				'NC' => 'Non-Community',
			],
			'_primary_source' => [
				'GW' => 'Groundwater',
				'SW' => 'Surface Water',
				'SWP' => 'Surface Water Purchased',
				'GUP' => 'Groundwater Under the Direct Influence of Surface Water Purchased',
				'GU' => 'Groundwater Under the Direct Influence of Surface Water',
				'GWP' => 'Groundwater Purchased'
			]
		];
    }

	// ------------ ADMIN
	public function enqueue_admin_styles() {
		wp_enqueue_style('water-utilities-admin-styles', get_stylesheet_directory_uri() . '/css/admin-water-utilities.css');
	}

    public function registerWaterUtilityPostType() {
        $labels = [
            'name' => 'Utilities',
            'singular_name' => 'Utility',
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'rewrite' => [
				'slug' => 'utilities',
			],
            'has_archive' => true,
            'supports' => ['title'],
            'taxonomies' => ['water_features', 'wastewater_features', 'stormwater_features', 'source_water'],
            'register_meta_box_cb' => [$this, 'addMetadataFields'],
        ];

        register_post_type('utility', $args);
    }


    public function renderMetadata($post) {

		$utilityMeta = get_post_meta($post->ID, 'utilityMeta', true);
		if (empty($utilityMeta)){
			$utilityMeta = $this->default_metadata();
		}

		extract($utilityMeta);

        // Output the form fields for metadata
		wp_nonce_field('water_utility_nonce', 'water_utility_nonce'); ?>

        <!-- HTML form fields for metadata -->
		<label for="state">State</label>
		<select name="state">
			<option value="AL" <?php echo ($state === 'AL') ? 'selected' : ''; ?>>Alabama</option>
			<option value="AK" <?php echo ($state === 'AK') ? 'selected' : ''; ?>>Alaska</option>
			<option value="AZ" <?php echo ($state === 'AZ') ? 'selected' : ''; ?>>Arizona</option>
			<option value="AR" <?php echo ($state === 'AR') ? 'selected' : ''; ?>>Arkansas</option>
			<option value="CA" <?php echo ($state === 'CA') ? 'selected' : ''; ?>>California</option>
			<option value="CO" <?php echo ($state === 'CO') ? 'selected' : ''; ?>>Colorado</option>
			<option value="CT" <?php echo ($state === 'CT') ? 'selected' : ''; ?>>Connecticut</option>
			<option value="DE" <?php echo ($state === 'DE') ? 'selected' : ''; ?>>Delaware</option>
			<option value="FL" <?php echo ($state === 'FL') ? 'selected' : ''; ?>>Florida</option>
			<option value="GA" <?php echo ($state === 'GA') ? 'selected' : ''; ?>>Georgia</option>
			<option value="HI" <?php echo ($state === 'HI') ? 'selected' : ''; ?>>Hawaii</option>
			<option value="ID" <?php echo ($state === 'ID') ? 'selected' : ''; ?>>Idaho</option>
			<option value="IL" <?php echo ($state === 'IL') ? 'selected' : ''; ?>>Illinois</option>
			<option value="IN" <?php echo ($state === 'IN') ? 'selected' : ''; ?>>Indiana</option>
			<option value="IA" <?php echo ($state === 'IA') ? 'selected' : ''; ?>>Iowa</option>
			<option value="KS" <?php echo ($state === 'KS') ? 'selected' : ''; ?>>Kansas</option>
			<option value="KY" <?php echo ($state === 'KY') ? 'selected' : ''; ?>>Kentucky</option>
			<option value="LA" <?php echo ($state === 'LA') ? 'selected' : ''; ?>>Louisiana</option>
			<option value="ME" <?php echo ($state === 'ME') ? 'selected' : ''; ?>>Maine</option>
			<option value="MD" <?php echo ($state === 'MD') ? 'selected' : ''; ?>>Maryland</option>
			<option value="MA" <?php echo ($state === 'MA') ? 'selected' : ''; ?>>Massachusetts</option>
			<option value="MI" <?php echo ($state === 'MI') ? 'selected' : ''; ?>>Michigan</option>
			<option value="MN" <?php echo ($state === 'MN') ? 'selected' : ''; ?>>Minnesota</option>
			<option value="MS" <?php echo ($state === 'MS') ? 'selected' : ''; ?>>Mississippi</option>
			<option value="MO" <?php echo ($state === 'MO') ? 'selected' : ''; ?>>Missouri</option>
			<option value="MT" <?php echo ($state === 'MT') ? 'selected' : ''; ?>>Montana</option>
			<option value="NE" <?php echo ($state === 'NE') ? 'selected' : ''; ?>>Nebraska</option>
			<option value="NV" <?php echo ($state === 'NV') ? 'selected' : ''; ?>>Nevada</option>
			<option value="NH" <?php echo ($state === 'NH') ? 'selected' : ''; ?>>New Hampshire</option>
			<option value="NJ" <?php echo ($state === 'NJ') ? 'selected' : ''; ?>>New Jersey</option>
			<option value="NM" <?php echo ($state === 'NM') ? 'selected' : ''; ?>>New Mexico</option>
			<option value="NY" <?php echo ($state === 'NY') ? 'selected' : ''; ?>>New York</option>
			<option value="NC" <?php echo ($state === 'NC') ? 'selected' : ''; ?>>North Carolina</option>
			<option value="ND" <?php echo ($state === 'ND') ? 'selected' : ''; ?>>North Dakota</option>
			<option value="OH" <?php echo ($state === 'OH') ? 'selected' : ''; ?>>Ohio</option>
			<option value="OK" <?php echo ($state === 'OK') ? 'selected' : ''; ?>>Oklahoma</option>
			<option value="OR" <?php echo ($state === 'OR') ? 'selected' : ''; ?>>Oregon</option>
			<option value="PA" <?php echo ($state === 'PA') ? 'selected' : ''; ?>>Pennsylvania</option>
			<option value="RI" <?php echo ($state === 'RI') ? 'selected' : ''; ?>>Rhode Island</option>
			<option value="SC" <?php echo ($state === 'SC') ? 'selected' : ''; ?>>South Carolina</option>
			<option value="SD" <?php echo ($state === 'SD') ? 'selected' : ''; ?>>South Dakota</option>
			<option value="TN" <?php echo ($state === 'TN') ? 'selected' : ''; ?>>Tennessee</option>
			<option value="TX" <?php echo ($state === 'TX') ? 'selected' : ''; ?>>Texas</option>
			<option value="UT" <?php echo ($state === 'UT') ? 'selected' : ''; ?>>Utah</option>
			<option value="VT" <?php echo ($state === 'VT') ? 'selected' : ''; ?>>Vermont</option>
			<option value="VA" <?php echo ($state === 'VA') ? 'selected' : ''; ?>>Virginia</option>
			<option value="WA" <?php echo ($state === 'WA') ? 'selected' : ''; ?>>Washington</option>
			<option value="WV" <?php echo ($state === 'WV') ? 'selected' : ''; ?>>West Virginia</option>
			<option value="WI" <?php echo ($state === 'WI') ? 'selected' : ''; ?>>Wisconsin</option>
			<option value="WY" <?php echo ($state === 'WY') ? 'selected' : ''; ?>>Wyoming</option>
		</select>

		<br>

		<label for="county">County</label>
		<input type="text" id="county" name="utilityMeta[county]" value="<?php esc_attr($county); ?>"><br>

		<label for="latitude">Latitude</label>
		<input type="text" id="latitude" name="utilityMeta[latitude]" value="<?php esc_attr($latitude); ?>"><br>

		<label for="longitude">Longitude</label>
		<input type="text" id="longitude" name="utilityMeta[longitude]" value="<?php esc_attr($longitude); ?>"><br>

		<label for="received_loan">Received DWSRF Loan</label>
		<input type="checkbox" id="received_loan" name="utilityMeta[received_loan]" <?php checked($received_loan, 1, false); ?>><br>

		<label for="facility_id">Facility ID#</label>
		<input type="text" id="facility_id" name="utilityMeta[facility_id]" value="<?php esc_attr($facility_id); ?>"><br>

		<label for="sewer">Sewer</label>
		<input type="checkbox" id="sewer" name="utilityMeta[sewer]" <?php checked($sewer, 1, false); ?>><br>

		<label for="drinking_water">Drinking Water</label>
		<input type="checkbox" id="drinking_water" name="utilityMeta[drinking_water]" <?php checked($drinking_water, 1, false); ?>><br>

		<label for="population">Population</label>
		<input type="number" id="population" name="utilityMeta[population]" value="<?php esc_attr($population); ?>"><br>

		<label for="domain">Domain (Public or Private)</label>
		<select id="domain" name="utilityMeta[domain]">
			<option value="Public" <?php selected($domain, 'Public', false); ?>>Public</option>
			<option value="Private" <?php selected($domain, 'Private', false); ?>>Private</option>
		</select><br>

		<label for="gis_urgency">GIS Urgency (1-5)</label>
		<input type="number" id="gis_urgency" name="utilityMeta[gis_urgency]" value="<?php esc_attr($gis_urgency); ?>" min="1" max="5"><br>

		<label for="meters">Meters</label>
		<input type="number" id="meters" name="utilityMeta[meters]" value="<?php esc_attr($meters); ?>"><?php
    }

    public function saveMetadata($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (get_post_type($post_id) !== 'utility') return;

		// Verify nonce
		if (!isset($_POST['water_utility_nonce']) || !wp_verify_nonce($_POST['water_utility_nonce'], 'water_utility_nonce')) {
			return $post_id;
		}

		$utilityMeta = [];
		foreach ($_POST['utilityMeta'] as $field => $value){
			switch ($field){
				// Sanitize Strings
				case 'state':
				case 'county':
				case 'facility_id':
				case 'domain':
					$utilityMeta[$field] = sanitize_text_field($value);
					break;
				// Sanitize Floats
				case 'latitude':
				case 'longitude':
					$utilityMeta[$field] = floatval($value);
					break;
				case 'population':
				case 'gis_urgency':
				case 'meters':
					$utilityMeta[$field] = intval($value);
					break;
				// Sanitize Boolean
				case 'received_loan':
				case 'sewer_water':
				case 'drinking_water':
					$utilityMeta[$field] = isset($value) ? 1 : 0;
					break;
			}
		}

        // Update metadata fields
		update_post_meta($post_id, 'utilityMeta', sanitize_text_field($utilityMeta));
    }

    public function registerTaxonomies() {
        register_taxonomy('source_water', 'utility', [
            'label' => 'Source Water',
            'hierarchical' => true,
            'rewrite' => ['slug' => 'source-water'],
        ]);

        register_taxonomy('water_features', 'utility', [
            'label' => 'Water Features',
            'hierarchical' => true,
            'rewrite' => ['slug' => 'water-features'],
        ]);

        register_taxonomy('wastewater_features', 'utility', [
            'label' => 'Wastewater Features',
            'hierarchical' => true,
            'rewrite' => ['slug' => 'wastewater-features'],
        ]);

        register_taxonomy('stormwater_features', 'utility', [
            'label' => 'Stormwater Features',
            'hierarchical' => true,
            'rewrite' => ['slug' => 'stormwater-features'],
        ]);
    }

	public function registerTaxonomyTerms() {
		// Terms for the 'source_water' taxonomy
		wp_insert_term('Surface', 'source_water');
		wp_insert_term('Ground', 'source_water');
		wp_insert_term('Purchased', 'source_water');

		// Terms for the 'water_features' taxonomy
		$water_features_terms = [
			'Booster Stations',
			'Customer Meters',
			'Fire Hydrants',
			'Intake Structures',
			'Lines',
			'Master/Inline Meters',
			'Monitoring Sites',
			'Reservoirs',
			'Storage Tanks',
			'Surface Intake',
			'Treatment Plants',
			'Valves',
			'Wells',
		];

		foreach ($water_features_terms as $term) {
			wp_insert_term($term, 'water_features');
		}

		// Terms for the 'wastewater_features' taxonomy
		$wastewater_features_terms = [
			'Cleanouts',
			'Collection Lines',
			'Lift Stations',
			'Outfall Structures',
			'Manholes',
			'Meters',
			'Monitoring Point',
			'Treatment Plants/Lagoons',
		];

		foreach ($wastewater_features_terms as $term) {
			wp_insert_term($term, 'wastewater_features');
		}

		// Terms for the 'stormwater_features' taxonomy
		$stormwater_features_terms = [
			'Cleanouts',
			'Inlets',
			'Lines',
			'Manholes',
		];

		foreach ($stormwater_features_terms as $term) {
			wp_insert_term($term, 'stormwater_features');
		}
	}


    public function addMetadataFields() {
        add_meta_box('water_utility_metadata', 'Utility Metadata', [$this, 'renderMetadata'], 'utility', 'normal', 'default');
    }



	// ------------ FRONTEND
	public function register_rest_routes() {
		register_rest_route('gs/v1', '/update-utility/(?P<id>\d+)', [
			'methods' => 'POST',
			'callback' => [&$this, 'update_utility_callback'],
			'permission_callback' => '__return_true',
			'args' => [
				'id' => [
					'validate_callback' => function($id, $request, $param){
						if (is_numeric( (int) $id) && $id > 0){
							return true;
						}
					}
				],
			],
		]);
		register_rest_route('gs/v1', '/utility-autocomplete', [
			'methods' => 'GET',
			'callback' => [&$this, 'utility_autocomplete'],
			'permission_callback' => '__return_true',
		]);
	}

	public function utility_autocomplete(WP_REST_Request $request){
		$query = $request->get_param('q');
		$utilityQuery = new WP_Query([
			'post_type'      => 'utility',
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'orderby'        => 'title',
			'order'          => 'ASC',
			's'              => $query,
		]);

		$utilities = [];

        while ($utilityQuery->have_posts()) {
            $utilityQuery->the_post();
            $utilities[] = [
				'id' => get_the_ID(),
				'title' => get_the_title()
			];
        }

        wp_reset_postdata();
		return $utilities;
	}

	public function update_utility_callback(WP_REST_Request $request) {
		$id = $request->get_param('id');

		$post = get_post($id);

		if (empty($post) || $post->post_type !== 'utility') {
			return new WP_Error('not_found', 'Utility not found', ['status' => 404]);
		}

		$user = wp_get_current_user();
		$data = $request->get_body();

		$userInventory = get_user_meta($user->ID, 'gis_inventory', true);
		$userInventory = empty($userInventory) ? [] : $userInventory;

		$inventory = get_post_meta($id, 'gis_inventory', true);
		$inventory = empty($inventory) ? [] : $inventory;

var_dump($data['agency']);
var_dump($data->agency);
die(); exit;


		$inventory[ $data['agency'] ] = [
			'date_added' => date('Y-m-d'),
			'feature_layers' => $data['featureLayers']
		];

		$userInventory[] = [
			'date_added' => date('Y-m-d'),
			'feature_layers' => $data['featureLayers']
		];

		$updatePost = update_post_meta( $id, 'gis_inventory', $inventory );
		$updateUser = update_user_meta( $user->ID, 'gis_inventory', $userInventory );

		if (is_wp_error($update)) {
			return new WP_Error('update_failed', 'Failed to update utility', ['status' => 500]);
		}

		// Return a success response
		return [
			'message' => 'Utility updated successfully',
			'data' => $data,
			'updatePost' => $updatePost,
			'updateUser' => $updateUser
		];
	}

	public function pre_get_posts($q){
		if ( is_admin() || ! $q->is_main_query() || ! $q->is_post_type_archive( 'utility' ) ) {
			return $q;
		}

		$q->set( 'orderby', 'title' );
		$q->set( 'order', 'ASC' );

		$q->set( 'meta_query', [[
			'key'     => '_status',
			'value'   => 'A',
			'compare' => '=',
		]]);

		$q->set('posts_per_page', 33);

		return;
	}

	public function add_archive_map($excerpt, $post){
		if ( is_admin() || ! is_main_query() || ! is_post_type_archive( 'utility' ) ) {
			return $excerpt;
		}

		return  '<iframe width="100%" height="260" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed/v1/place?key=' . GOOGLE_API_KEY . '&maptype=satellite&zoom=10&q=' . urlencode($post->post_title) . '"></iframe>';
	}

	public function add_archive_last_updated($the_date, $format, $post) {
		if ( is_admin() || ! is_main_query() || ! is_post_type_archive( 'utility' ) ) {
			return $the_date;
		}

		$author = get_the_author();

		// @TODO: Link author name to Bio Page
		return 'Last Updated: ' . $the_date . ' by ' . (empty($author) || is_numeric($author) ? 'Lindsay' : $author);
	}

	public function print_meta($atts){
		extract(shortcode_atts([
			'key' => '',
		], $atts));

		if ( empty( $key) ) { return ''; }

		global $post;
		$value = get_post_meta( $post->ID, $key, true );

		if ( empty( $value ) ) { return ''; }

		switch ($key) {
			case 'gis_inventory':
				return count($value['gis_inventory']['feature_layers'] ?? []);
			case '_service_connections':
				return $value[0]['count'] ?? 0;
			case '_population_served':
				return $value['population_served'] ?? 0;
		}

		if ( is_array( $value ) ){
			// @TODO: Loop / table data...
			return $value;
		}

		return $this->translations[$key][$value] ?? $value;
	}

	public function utility_rating(){
		return rand(0,5);
	}


	// ------------ SHARED
	private function default_metadata() {
		return [
			'facility_id' => 0,
			'state' => '',
			'county' => '',
			'latitude' => 0.0,
			'longitude' => 0.0,
			'received_loan' => false,
			'sewer' => false,
			'drinking_water' => false,
			'population' => 0,
			'domain' => 'Public',
			'gis_urgency' => 1,
			'meters' => 0,
		];

		return $default_metadata;
	}
}

// Instantiate the WaterUtility class
$waterUtility = new WaterUtility();

