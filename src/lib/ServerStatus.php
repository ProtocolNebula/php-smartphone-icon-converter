<?php /**
 * @name serverStatus for Kernel Web
 * @version 1.0
 * @copyright ArrayZone 2014
 * @license AZPL or later; see License.txt or http://arrayzone.com/license
 * @category plugin
 * 
 * Description: Muestra informacion sobre los recursos del servidor
 * 
 * Useful Functions
 * convertByte($unit, $divisor = 1024);
 * memoryUsed();
 */
class ServerStatus {
	
	/**
	 * @name convertByte
	 * This function convert Byte to maximum divisible unit (EX: 1024 bytes return 1 KB)
	 * @param integer $unit Number of memory to calculate
	 * @param integer $divisor Quantity of blocks for each unit
	 * @return string
	 */
	static function convertByte($unit, $divisor = 1024) {
		$totReductions = 0; // Calculate total reductions applyed
		while ($unit >= $divisor) {
			$unit /= $divisor;
			++$totReductions;
		}
		
		return $unit . ' ' . self::unitType($totReductions);
	}
	
	/**
	 * @name unitType
	 * @param integer $id Specify unit ID (0 = Byte, 1 = KB...)
	 * @param integer $type Specify type of unit (Bytes, Bits, ibybytes...)
	 * @return string Memory unit
	 */
	static function unitType($id, $type = 'B') {
		switch ($id) {
			case 0:
				return $type;
				break;
			case 1:
				return 'K'.$type;
				break;
			case 2:
				return 'M'.$type;
				break;
			case 3:
				return 'G'.$type;
				break;
			case 4:
				return 'T'.$type;
				break;
			case 5:
				return 'P'.$type;
				break;
		}
	}
	
	/**
	 * @name memoryUsed
	 * @return string Memory used (in Byte/KB/MB...)
	 */
	static function memoryUsed() {
		return self::convertByte(memory_get_usage());
	}
	
	static function totalMemoryUsed() {
		return self::convertByte(memory_get_peak_usage());
	}
	

	/**
	 * @name calctime
	 * @param boolean $showTime If is true, it show text with time result
	 * @param boolean $showMemory If $showTime is tru and this is true, show memory used too
	 */
	static function calcTime($showResult = true, $showMemory = true) {
		static $timeStart; // it save in miliseconds time 
		
		if (!$timeStart) {
			// Saving current time
			$timeStart = array_sum(explode(" ", (isset($_SERVER["REQUEST_TIME_FLOAT"])) ? $_SERVER["REQUEST_TIME_FLOAT"] : microtime()));
		} else {
			// Calculating total time
			$total = array_sum(explode(" ", microtime())) - $timeStart;
			if ($showResult) {
				echo 'Page loaded in ' , $total , ' seconds.';
				//self::memoryUsed() , ' with a total of ' ,
				if ($showMemory) echo '<br />Memory Used: ' , self::MemoryUsed() , '<br />', 
					'Peak memory allocated by PHP: ' , self::totalMemoryUsed();
			}
		}
	}
}