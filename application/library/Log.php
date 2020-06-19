<?php
class Log{
    private static $logpath = LOG_DIR;

	public static function writeLog($strFileName, $strFix ,$strMSG) {
		if (!file_exists(self::$logpath))
		{
			if (!mkdir(self::$logpath, '0777'))
			{
                die("error");
			}
		}
		elseif (!is_dir(self::$logpath))
		{
            die("error");
		}
		else
		{
			if (!is_writable(self::$logpath))
			{
				@chmod(self::$logpath, 0777);
			}
			$logfile = rtrim(self::$logpath, '/') . '/' . $strFileName . '.log';
			if (file_exists($logfile) && !is_writable($logfile))
			{
				@chmod($logfile, 0644);
			}
			$handle = @fopen($logfile, "a");
			if ($handle)
			{
				if (!empty($strMSG)){
					$strContent = $strFix.':'.$strMSG."\n";
				}
				else {
					$strContent = $strFix."\n";
				}
				if (!fwrite($handle, $strContent))
				{
					@fclose($handle);
					die("Write permission deny");
				}
				@fclose($handle);
			}
		}
	}

	/**
	 * 读文件内容
	 *
	 * @param $strFileName
	 *
	 * @return bool|string
	 */
	public static function readLog($strFileName) {
		$logfile = trim(self::$logpath, '/') . '/' . $strFileName . '.log';
		if (file_exists($logfile) && is_readable($logfile))
		{
			$strContent = '';
			$handler = @fopen($logfile, 'r');
			if ($handler)
			{
				while (!feof($handler))
				{
					$strContent .= fgets($handler);
				}
				@fclose($handler);
			}

			return $strContent;
		}

		return false;
	}
}