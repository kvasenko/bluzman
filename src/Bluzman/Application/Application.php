<?php
/**
 * @created 2013-11-28 12:31
 * @author Pavel Machekhin <pavel.machekhin@gmail.com>
 */

namespace Bluzman\Application;

use Bluzman\Command;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Application extends Console\Application
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param \Bluzman\Application\Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return \Bluzman\Application\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        $this->setConfig(new Config($this));
        $this->registerCommands();
    }

    /**
     * Returns the path to the directory with bluzman application
     *
     * @return string
     */
    public function getWorkingPath()
    {
        return getcwd();
    }

    /**
     * Removed some commands from default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),

            new InputOption('--env',     '-e', InputOption::VALUE_OPTIONAL, 'The environment to be used.', 'dev'),
            new InputOption('--help',    '-h', InputOption::VALUE_NONE, 'Display this help message.'),
            new InputOption('--quiet',   '-q', InputOption::VALUE_NONE, 'Do not output any message.'),
            new InputOption('--verbose', '-v', InputOption::VALUE_NONE, 'Increase verbosity of messages.'),
            new InputOption('--version', '-V', InputOption::VALUE_NONE, 'Display this application version.')
        ));
    }

    /**
     * @todo
     */
    protected function registerCommands()
    {
        $this->addCommands([
            new Command\ServerCommand,
            new Command\TestCommand,
            new Command\Init\AllCommand
        ]);
    }
}
