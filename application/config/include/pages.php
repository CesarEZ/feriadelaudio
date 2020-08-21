<?php 
require_once( APPPATH .'helpers/common_helper.php');

$pages = get_pages();

foreach ($pages as $page) {
	$page['slug'] = 'auth/page/'.$page['slug'];
}