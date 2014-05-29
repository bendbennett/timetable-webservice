<?php

/**
 * Resource plugin that sets up the user session
 *
 * @author Adam Cooper <adam.cooper@nottingham.ac.uk>
 */
class Resource_Session extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * Default registry key
	 */
	const DEFAULT_REGISTRY_KEY = 'App_Session';

	/**
	 * Default namespace for session
	 */
	const DEFAULT_SESSION_NAMESPACE = 'App_Session';

	/**
	 * Default session expiry time in seconds
	 */
	const DEFAULT_SESSION_EXPIRATION = 3600; // 1 Hour

	/**
	 * Session instance
	 *
	 * @var Zend_Session_Namespace
	 */
	protected $_sessionInstance = null;

	/* (non-PHPdoc)
	 * @see Zend_Application_Resource_Resource::init()
	 */
	public function init()
	{
		return $this->getSession();
	}

	/**
	 * Return session instance
	 *
	 * @return Zend_Session_Namespace
	 */
	public function getSession()
	{
		if (null === $this->_sessionInstance)
		{
			$options = $this->getOptions();

			// Creating a new namespace automatically calls Zend_Session::Start()
			$namespace = (isset($options['namespace']) && !is_numeric($options['namespace'])) ? $options['namespace'] : self::DEFAULT_SESSION_NAMESPACE;
			$this->_sessionInstance = new Zend_Session_Namespace($namespace);

			// Set the expiry on the session
			$expiry = (isset($options['expiration']) && !is_numeric($options['expiration'])) ? $options['expiration'] : self::DEFAULT_SESSION_EXPIRATION;
			$this->_sessionInstance->setExpirationSeconds($expiry);

			// add to registry
			$key = (isset($options['registry_key']) && !is_numeric($options['registry_key'])) ? $options['registry_key'] : self::DEFAULT_REGISTRY_KEY;
			Zend_Registry::set($key, $this->_sessionInstance);
		}

		return $this->_sessionInstance;
	}
}