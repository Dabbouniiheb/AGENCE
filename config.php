<?php
/**
 * Site configuration - ready for future database integration.
 * Define base path, DB settings here when needed.
 */
// Base URL path (empty if site runs from root; set e.g. '/AGENCE' if in subfolder)
$base_url = '';

// Future database configuration (uncomment and set when ready)
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'agence_voyages');
// define('DB_USER', '');
// define('DB_PASS', '');

// Current page identifier: 'index' or 'tunisie' (set in each page before including header)
if (!isset($current_page)) {
    $current_page = 'index';
}