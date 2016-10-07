<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\DirectoryRegister\DI;

use Nette,
	Nette\Utils\Finder;

class AutoRegisterExtension extends Nette\DI\CompilerExtension
{

	private $defaults = [
		'dirs' => [],
		'interfaces' => [],
		'skip' => [],
		'cache' => 'Nette\Caching\Storages\FileStorage',
	];


	public function __construct()
	{
		$this->defaults['cache'] = new Nette\DI\Statement($this->defaults['cache'], ['%tempDir%/cache']);
	}

	public function loadConfiguration()
	{
		$config = $this->_getConfig();

		$builder = $this->getContainerBuilder();

		foreach ($config['dirs'] as $namespace => $dir) {
			if (is_dir($dir)) {
				foreach (Finder::findFiles('*.php')->in($dir) as $key => $file) {
					$class = $file->getBasename('.php');

					$refletion = new \ReflectionClass("$namespace\\$class");

					if (in_array($refletion->getName(), $config['skip'])) {
						continue;
					}

					if ($refletion->isInstantiable()) {
						$builder->addDefinition($class)
							->setClass($refletion->getName());
					}
				}
			}
		}

		if(!empty($config['interfaces'])) {
			$interfaces = array_keys($config['interfaces']);
			$loader = new Nette\Loaders\RobotLoader;
			$loader->setCacheStorage($config['cache']);
			foreach ($config['interfaces'] as $dir) {
				if (is_dir($dir)) {
					$loader->addDirectory($dir);
				}
			}
			$loader->register();
			foreach ($loader->getIndexedClasses() as $class => $file) {
				if (empty(array_intersect(class_implements($class), $interfaces))) {
					continue;
				}

				$refletion = new \ReflectionClass($class);

				if ($refletion->isInstantiable()) {
					$builder->addDefinition($class)
						->setClass($class);
				}
			}
		}
	}


	private function _getConfig()
	{
		$config = $this->validateConfig($this->defaults, $this->config);

		return $config;
	}

}
