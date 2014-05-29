<?php

/**
 * Resource plugin that implements a globally accessible config
 *
 * @author Adam Cooper <adam.cooper@nottingham.ac.uk>
 */
class Resource_Config extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * Default registry key
	 */
	const DEFAULT_REGISTRY_KEY = 'App_Config';

	/**
	 * Cache instance
	 *
	 * @var Zend_Config
	 */
	protected $_config = null;

	/* (non-PHPdoc)
	 * @see Zend_Application_Resource_Resource::init()
	 */
	public function init()
	{
		return $this->getConfig();
	}

	/**
	 * Return config instance
	 *
	 * @return Zend_Config
	 */
	public function getConfig()
	{
		if (null === $this->_config) {
			$options = $this->getOptions();
			$config = $this->getBootstrap()->getApplication()->getOptions();

			$this->_config = new Zend_Config($config);

			/// add to registry
			$key = (isset($options['registry_key']) && !is_numeric($options['registry_key'])) ? $options['registry_key'] : self::DEFAULT_REGISTRY_KEY;
			Zend_Registry::set($key, $this->_config);
		}
		return $this->_config;
	}
}