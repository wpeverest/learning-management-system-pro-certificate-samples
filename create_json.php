<?php
/**
 * Process the samples directory and creates a single json file to be used by the PRO plugin.
 */

$samples_dir = dirname(__FILE__) . '/samples';
$raw_github_url = 'https://raw.githubusercontent.com/wpeverest/learning-management-system-pro-certificate-samples/master';

$samples_directories   = scandir($samples_dir);

// Remove current directory and previous directory form the list.
$samples_directories = array_filter(
    $samples_directories,
    function ( $samples_directory ) {
        return '.' !== $samples_directory && '..' !== $samples_directory;
    }
);

// Remove sample directories if it is not directory.
$samples_directories = array_filter(
    $samples_directories,
    function ( $samples_directory ) {
        return ! is_dir($samples_directory);
    }
);

// Create an array of the samples.
$samples_arr = [];

foreach( $samples_directories as $dir_name ) {
    $html = dirname(__FILE__) . "/samples/{$dir_name}/content.html";
    $image = "{$raw_github_url}/samples/{$dir_name}/background-image.png";
    $title = dirname(__FILE__) . "/samples/{$dir_name}/title.txt";

    if (! ( is_readable($html)  && is_readable($html) && is_readable($title) ) ) {
        continue;
    }

    $samples_arr[] = array(
        'id' => $dir_name,
        'html' => file_get_contents($html),
        'title' => trim(file_get_contents($title)),
        'backgroundImage' => $image,
    );
}

$samples_arr_json = json_encode($samples_arr);

file_put_contents('samples.json', $samples_arr_json);
