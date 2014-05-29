<?php

/**
 * Resource plugin that implements configuration driven logging
 *
 * Adapted from from http://www.zfsnippets.com/snippets/view/id/72
 *
 * @author Adam Cooper <adam.cooper@nottingham.ac.uk>
 */
class Resource_Logger extends Zend_Application_Resource_ResourceAbstract
{
	/*
	 1.EMERG   = 0;  // Emergency: system is unusable
	 2.ALERT   = 1;  // Alert: action must be taken immediately
	 3.CRIT    = 2;  // Critical: critical conditions
	 4.ERR     = 3;  // Error: error conditions
	 5.WARN    = 4;  // Warning: warning conditions
	 6.NOTICE  = 5;  // Notice: normal but significant condition
	 7.INFO    = 6;  // Informational: informational messages
	 8.DEBUG   = 7;  // Debug: debug messages
	 */
	/**
	 * Default registry key
	 */
	const DEFAULT_REGISTRY_KEY = 'App_Logger';

	/**
	 * Cache instance
	 *
	 * @var Zend_Log
	 */
	protected $_loggerInstance = null;

	/* (non-PHPdoc)
	 * @see Zend_Application_Resource_Resource::init()
	 */
	public function init()
	{

		return $this->getLogger();
	}

	/**
	 * Return logger instance
	 *
	 * @return Zend_Log
	 */
	public function getLogger()
	{
		if (null === $this->_loggerInstance)
		{
			$options = $this->getOptions();

			if ($options['logging'])
			{
				try
				{
					$this->_loggerInstance = new Zend_Log();
					$stream = @fopen($options['logfile'], 'a+', false);

					if (! $stream)
					{
						throw new Exception('Failed to open log file at ' .  $options['logfile']);
					}
					else
					{
						$stream = new Zend_Log_Writer_Stream($options['logfile']);
						$this->_loggerInstance->addWriter($stream);
							
						// add to registry
						$key = (isset($options['registry_key']) && !is_numeric($options['registry_key'])) ? $options['registry_key'] : self::DEFAULT_REGISTRY_KEY;
						Zend_Registry::set($key, $this->_loggerInstance);

						return $this->_loggerInstance;
					}
				}
				catch(Exception $loggingException)
				{
					echo 'logging is enabled but logfile cannot be found - please contact administrator';
					echo '<br />err message:'.$loggingException->getMessage();
					exit;
				}
			}
		}
	}
}