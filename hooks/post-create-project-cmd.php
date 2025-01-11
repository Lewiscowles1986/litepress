<?php

namespace Vendor\Project;

use Composer\Script\Event;

class Setup
{
    public static function handle(Event $event)
    {
        $io = $event->getIO();

        // Prompt user for inputs
        $projectName = $io->ask('What is the name of your project?', 'MyProject');
        $authorName = $io->ask('What is the author name?', 'John Doe');
        $useDatabase = $io->askConfirmation('Do you want to use a database? [yes/no]', true);

        // Prepare configuration
        $config = [
            'projectName' => $projectName,
            'authorName' => $authorName,
            'useDatabase' => $useDatabase,
        ];

        // Write to JSON file
        $configFile = __DIR__ . '/../config.json';
        file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));

        $io->write("Configuration saved to $configFile");
    }
}
