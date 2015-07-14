<?php

namespace Gourmet\Whoops\Handler;

use UnexpectedValueException;
use Whoops\Handler\PrettyPageHandler as WhoopsPrettyPageHandler;

class PrettyPageHandler extends WhoopsPrettyPageHandler
{

	protected $hostRoot = null;

	/**
	 * Given a string file path, and an integer file line,
	 * executes the editor resolver and returns, if available,
	 * a string that may be used as the href property for that
	 * file reference.
	 *
	 * @throws UnexpectedValueException If editor resolver does not return a string
	 * @param  string                   $filePath
	 * @param  int                      $line
	 * @return string|bool
	 */
	public function getEditorHref($filePath, $line)
	{
		$url = parent::getEditorHref($filePath, $line);

		if ($this->hostRoot) {
			$hostFilePath = str_replace(ROOT, $this->hostRoot, $filePath);
			$url = str_replace(rawurlencode($filePath), rawurlencode($hostFilePath), $url);
		}

		return $url;
	}

	public function setHostRoot($path) {
		$this->hostRoot = $path;
	}
}
