<?php

namespace Vendor\Project;

function ask($question, $default='') {
    echo implode(" ", [$question, $default, PHP_EOL]);
    $stdin = fopen("php://stdin", "r");
    $response = trim(fgets($stdin));
    fclose($stdin);
    return $response;
}

function confirmation($question, $default = null, $choices = ['yes', 'no']) {
    while (true) {
        $defaultIsSet = !is_null($default);
        $response = ask($question, $defaultIsSet ? ($default ? $choices[0] : $choices[1]) : "");
        if (strtolower($response) === 'yes') {
            return true;
        } elseif (strtolower($response) === 'no') {
            return false;
        } elseif ($defaultIsSet) {
            return $default;
        }
        echo "Please type 'yes' or 'no'.\n";
    }
}

$projectName = basename(getcwd()) ?? 'litepress-demo';
$domainName = "127.0.0.1";
$useHttps = false;

if (stream_isatty(STDIN)) {
    // Prompt user for inputs
    $projectName = ask('What is the name of your project?', $projectName);
    $domainName = ask('What is the domain name, or ip you wish to run on?', '127.0.0.1');
    $useHttps = confirmation('Do you want to use https? [yes/no]', false);
}

// Prepare configuration
$config = [
    'projectName' => $projectName,
    'domainName' => $domainName,
    'useHttps' => $useHttps,
];

// Write to JSON file
$configFile = getcwd() . '/config.json';

echo "Trying to write configFile to '$configFile'" . PHP_EOL;
file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));

echo "Configuration saved to '$configFile'" . PHP_EOL;
