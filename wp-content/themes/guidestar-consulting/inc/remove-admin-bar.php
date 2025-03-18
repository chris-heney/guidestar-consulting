<?php

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator')) {
		show_admin_bar(false);
	}
}
