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
		'skip' => []
	];


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
	}


	private function _getConfig()
	{
		$config = $this->validateConfig($this->defaults, $this->config);

		return $config;
	}

}
