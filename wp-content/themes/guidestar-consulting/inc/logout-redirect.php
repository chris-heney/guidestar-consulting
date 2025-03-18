<?php

add_filter( 'logout_redirect', function( $redirect_to, $requested_redirect_to, $user ) {
	if ( wp_redirect( '/' ) ) {
		exit;
	}
}, 10, 3);

