<?php

namespace Gourmet\Whoops\Error;

use Cake\Core\Configure;
use Cake\Error\ErrorHandler;
use Whoops\Run;
use Gourmet\Whoops\Handler\PrettyPageHandler;

class WhoopsHandler extends ErrorHandler
{
	protected $_whoops;

	public function getWhoopsInstance()
	{
		if (empty($this->_whoops)) {
			$this->_whoops = new Run();
		}

		$handler = new PrettyPageHandler();

		if ($this->_options['handler']['editor']) {
			$handler->setEditor($this->_options['handler']['editor']);
		}

		if ($this->_options['handler']['hostRoot']) {
			$handler->setHostRoot($this->_options['handler']['hostRoot']);
		}

		$this->_whoops->pushHandler($handler);

		return $this->_whoops;
	}

	protected function _displayError($error, $debug)
	{
		if ($debug) {
			$whoops = $this->getWhoopsInstance();
			$whoops->handleError($error['level'], $error['description'], $error['file'], $error['line']);
		} else {
			parent::_displayError($error, $debug);
		}
	}

	protected function _displayException($exception)
	{
		if (Configure::read('debug')) {
			$whoops = $this->getWhoopsInstance();
			$whoops->handleException($exception);
		} else {
			parent::_displayException($exception);
		}
	}
}
