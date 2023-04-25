<?php
/**
 * @package   admintoolswp
 * @copyright Copyright (c)2017-2023 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU GPL version 3 or later
 */

namespace Akeeba\AdminTools\Admin\Model;

use Akeeba\AdminTools\Admin\Helper\Language;
use Akeeba\AdminTools\Library\Mvc\Model\Model;

defined('ADMINTOOLSINC') or die;

class EmergencyOffline extends Model
{
	/**
	 * Checks if the Emergency Off-Line Mode .htaccess backup exists
	 *
	 * @return  bool
	 */
	public function isOffline()
	{
		$backupFile = ABSPATH . '.htaccess.eom';

		if (is_file($backupFile))
		{
			$filedata = file_get_contents($backupFile);
			$lines    = explode("\n", $filedata);

			if (!empty($lines))
			{
				if (trim($lines[0]) == '## EOMBAK - Do not remove this line or this file')
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Tries to put the site in Emergency Off-Line Mode, backing up the original .htaccess file
	 *
	 * @return  bool True on success
	 */
	public function putOffline()
	{
		// If the backup doesn't exist, try to create it
		$htaccessFilePath = ABSPATH . '.htaccess';

		if (!$this->isOffline())
		{
			$backupFile = ABSPATH . '.htaccess.eom';
			$sourceFile = $htaccessFilePath;

			if (@file_exists($sourceFile))
			{
				$sourceData = file_get_contents($sourceFile);
				$sourceData = "## EOMBAK - Do not remove this line or this file\n" . $sourceData;
				$result     = file_put_contents($backupFile, $sourceData);

				if (!$result)
				{
					return false;
				}

				@unlink($sourceFile);
			}
			else
			{
				$sourceData = "## EOMBAK - Do not remove this line or this file\n";
				$result     = @file_put_contents($backupFile, $sourceData);

				if (!$result)
				{
					return false;
				}
			}
		}

		// Create the offline.html file, if it doesn't exist. If you can't create it, don't worry too much.
		$offlineFile = ABSPATH . 'offline.html';

		if (!@file_exists($offlineFile))
		{
			$message  = Language::_('COM_ADMINTOOLS_EOF_OFFLINE_MESSAGE');
			$sitename = get_bloginfo('name');

			$fileContents = <<<ENDHTML
<html>
<head>
	<title></title>
</head>
<body style="margin:10em;">
	<div style="border: thin solid #333; border-radius: 5px; width: 70%; margin: 0 15%; padding: 2em; background-color: #e0e0e0; font-size: 14pt;">
		<img src="wp-admin/images/wordpress-logo.png" align="middle" />
		<h1>
			$sitename
		</h1>
		<p>
			$message
		</p>
	</div>
</body>
</html>
ENDHTML;
			@file_put_contents($offlineFile, $fileContents);
		}

		$htaccess = $this->getHtaccess();

		$result = @file_put_contents($htaccessFilePath, $htaccess);

		return $result;
	}

	/**
	 * Puts the site back on-line
	 *
	 * @return  bool  True on success
	 */
	public function putOnline()
	{
		if (!$this->isOffline())
		{
			return false;
		}

		$htaccessPath    = ABSPATH . '.htaccess';
		$oldHtaccessPath = ABSPATH . '.htaccess.eom';

		$result = @unlink($htaccessPath);

		if (@file_exists($oldHtaccessPath))
		{
			$filedata = @file($oldHtaccessPath);
			$newLines = array();
			$lookFor  = "## EOMBAK - Do not remove this line or this file";

			foreach ($filedata as $line)
			{
				if (trim($line) == $lookFor)
				{
					continue;
				}

				$newLines[] = trim($line);
			}

			$filedata = implode("\n", $newLines);

			$result = @file_put_contents($htaccessPath, $filedata);
		}

		if ($result)
		{
			@unlink($oldHtaccessPath);
		}

		return $result;
	}

	/**
	 * Returns the contents of the stealthy .htaccess file
	 *
	 * @return string
	 */
	public function getHtaccess()
	{
		// Sniff the .htaccess for a RewriteBase line
		$rewriteBase = '';
		$sourceFile = ABSPATH . '.htaccess.eom';

		if (!@file_exists($sourceFile))
		{
			$sourceFile = ABSPATH . '.htaccess';
		}

		if (@file_exists($sourceFile))
		{
			$sourceData = @file($sourceFile);

			foreach ($sourceData as $line)
			{
				$line = trim($line);

				if (substr($line, 0, 12) == 'RewriteBase ')
				{
					$rewriteBase = $line;

					break;
				}
			}
		}

		/** @var ControlPanel $cpanelModel */
		// It's not the best thing to do, but in WP we don't have a container or something like that
		// We only need it to fetch the IP, so we can live with that
		$cpanelModel = new ControlPanel($this->input);

		// And finally create our stealth .htaccess
		$ip = $cpanelModel->getVisitorIP();
		$ip = str_replace('.', '\\.', $ip);

		$htaccess = <<<ENDHTACCESS
RewriteEngine On
$rewriteBase
RewriteCond %{REMOTE_HOST}        !$ip
RewriteCond %{REQUEST_URI}        !offline\.html
RewriteCond %{REQUEST_URI}        !(\.png|\.jpg|\.gif|\.jpeg|\.bmp|\.swf|\.css|\.js)$
RewriteRule (.*)                  offline.html    [R=307,L]

ENDHTACCESS;

		return $htaccess;
	}
}
