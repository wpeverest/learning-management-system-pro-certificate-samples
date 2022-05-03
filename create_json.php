<?php
/**
 * Process the templates directory and creates a single json file to be used by the PRO plugin.
 */

$templates_dir = dirname( __FILE__ ) . '/templates';
$raw_github_url = 'https://raw.githubusercontent.com/wpeverest/learning-management-system-pro-certificate-templates/master';

$samples_directories   = scandir( $templates_dir);

// Remove current directory and previous directory form the list.
$samples_directories = array_filter(
    $samples_directories,
    function( $samples_directory ) {
        return '.' !== $samples_directory && '..' !== $samples_directory;
    }
);

// Remove sample directories if it is not directory.
$samples_directories = array_filter(
    $samples_directories,
    function( $samples_directory ) {
        return ! is_dir( $samples_directory );
    }
);

// Create an array of the samples.
$samples_arr = [];
foreach( $samples_directories as $samples_directory ) {
    $html = dirname( __FILE__ ) . "/templates/{$samples_directory}/{$samples_directory}.html";
    $image = "{$raw_github_url}/templates/{$samples_directory}/{$samples_directory}.png";
    $title = dirname( __FILE__ ) . "/templates/{$samples_directory}/{$samples_directory}.txt";

    if ( ! ( is_readable( $html )  && is_readable( $html ) && is_readable( $title ) ) ) {
        continue;
    }

    $samples_arr[] = array(
        'html' => file_get_contents( $html ),
        'image' => $image,
        'title' => file_get_contents( $title ),
    );
}

$samples_arr_json = json_encode( $samples_arr );

file_put_contents( 'templates.json', $samples_arr_json );
