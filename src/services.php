<?php
use Zend\ServiceManager\ServiceManager;

use App\Command\Zabbix\Trigger\ListCommand as ListTriggerCommand;
use App\Command\Zabbix\Trigger\GetCommand as GetTriggerCommand;

use Symfony\Component\Yaml\Yaml;

return [
  'factories' => [

    ListTriggerCommand::class => function (ServiceManager $serviceManager) {
      return new ListTriggerCommand($serviceManager);
    },

    GetTriggerCommand::class => function (ServiceManager $serviceManager) {
      return new GetTriggerCommand($serviceManager);
    },

    Yaml::class => function (ServiceManager $serviceManager) {
      $configFile = '/etc/zabbix-triggers.yaml';
      $altConfigFile = __DIR__ . '/../config/parameters.yaml';

      if (file_exists($configFile)) {
        return Yaml::parseFile($configFile);
      } 
      if (file_exists($altConfigFile)) {
        return Yaml::parseFile($altConfigFile);
      }

      printf('No configuration found using defaults (parameters.yaml.dist)' . PHP_EOL . PHP_EOL, $altConfigFile);

      return Yaml::parseFile(sprintf('%s.dist', $altConfigFile));
    }

  ],
];