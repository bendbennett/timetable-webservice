<?php

/**
 * Resource plugin that implements configuration driven caching
 *
 * Taken wholesale from http://www.zfsnippets.com/snippets/view/id/72
 *
 * @author Adam Cooper <adam.cooper@nottingham.ac.uk>
 */
class Resource_Cache extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * Default registry key
	 */
	const DEFAULT_REGISTRY_KEY = 'App_Cache';

	/**
	 * Cache instance
	 *
	 * @var Zend_Cache
	 */
	protected $_cache = null;

	/* (non-PHPdoc)
	 * @see Zend_Application_Resource_Resource::init()
	 */
	public function init()
	{
		return $this->getCache();
	}

	/**
	 * Return cache instance
	 *
	 * @return Zend_Cache
	 */
	public function getCache()
	{
		if (null === $this->_cache) {
			$options = $this->getOptions();

			/// create cache instance
			$this->_cache = Zend_Cache::factory(
			$options['frontend']['adapter'],
			$options['backend']['adapter'],
			$options['frontend']['params'],
			$options['backend']['params']
			);

			/// use as default database metadata cache
			if (isset($options['isDefaultMetadataCache']) && true === (bool) $options['isDefaultMetadataCache']) {
				Zend_Db_Table_Abstract::setDefaultMetadataCache($this->_cache);
			}

			/// use as default translate cache
			if (isset($options['isDefaultTranslateCache']) && true === (bool) $options['isDefaultTranslateCache']) {
				Zend_Translate::setCache($this->_cache);
			}

			/// use as default locale cache
			if (isset($options['isDefaultLocaleCache']) && true === (bool) $options['isDefaultLocaleCache']) {
				Zend_Locale::setCache($this->_cache);
			}

			/// add to registry
			$key = (isset($options['registry_key']) && !is_numeric($options['registry_key'])) ? $options['registry_key'] : self::DEFAULT_REGISTRY_KEY;
			Zend_Registry::set($key, $this->_cache);
		}
		return $this->_cache;
	}

	/**
	 * Converts a given string into a cache friendly string to be used as a key
	 * @param string $string_to_key The string to make key friendly
	 * @return string The string which should be safe to use as a key
	 */
	public static function makeKey($string_to_key)
	{
		// Non alpha-numeric characters in the string.
		$string = preg_replace("/[^a-zA-Z0-9_]/", "_", $string_to_key);

		return $string;
	}
}