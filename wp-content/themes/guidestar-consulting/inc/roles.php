<?php

add_role( 'service_provider_gis', 'GIS Service Provider', [ 'service_provider_gis' ] );
add_role( 'service_provider_other', 'General Service Provider', [ 'service_provider_other' ] );
add_role( 'product_vendor_gis', 'GIS Product Vendor', [ 'product_vendor_gis' ] );
add_role( 'product_vendor_other', 'General Product Vendor', [ 'product_vendor_other' ] );
add_role( 'sponsor', 'GIS Collaboritive Sponsor', ['sponsor'] );
add_role( 'government_agency', 'Government Agency Employee', [ 'government_agency' ] );
add_role( 'utility_operator', 'Utility Operator', [ 'utility_operator' ] );
add_role( 'utility_manager', 'Utility Manager', [ 'utility_manager' ] );

add_action( 'gform_user_registered', function( $user_id, $feed, $entry, $password ) {

	$user = get_user_by( 'id', $user_id );

	if ( !$user ) { return; }

	$specified_role = get_user_meta( $user_id, 'specified_role', true );

	if ( empty( $specified_role ) ) { return; }

	$user->add_role( $specified_role );
}, 10, 4);
