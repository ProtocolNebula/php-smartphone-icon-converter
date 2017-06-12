<?php /**
 * @name DirectoryManager for Kernel Web
 * @version 1.0
 * @copyright ArrayZone 2014
 * @license AZPL or later; see License.txt or http://arrayzone.com/license
 * @category plugin
 * 
 * Description: It can manage and manipulate directorys easily
 */
class DirectoryManager {
	
	/**
	 * @name delete This function can delete a folder completely
	 * 	You can specify some values to only empty or only empty him files (and subdirectories)
	 * 	So this function give a lot of possibilites
	 * @param string $dir Directory to delete
	 * @param boolean $myself If is true, delete himself
	 * @param boolean $deleteDirs If is true delete subfolders too
	 * @param boolean $recursive If is true, it will do it recursivelly (seraching in each subfolder)
	 * @param number $dateOld Seconds minimum since it was created to can delete directory/file. If is 0 it will be deleted instead
	 * 	time() - 24 * 60 * 60; // Delete files with 24 hours of antique
	 * 	time() - strtotime("-1 day");
	 * 	You can put the number negative to delete only FILES NEWERS THAN
	 * @param array $exceptions Specify name of files/directories to not delete
	 * 	WARNING: IT DON'T RECOGNIZE * or ?, ONLY FULL NAMES
	 * @param boolean $subdir Internal function var (DON'T CHANGE IT)
	 * @return boolean WARNING: It can return "false" but it can be deleted any 
	 * 
	 * @example
	 * DirectoryManager::delete('directorio', true); // It don't do nothing (for safety reasons)
	 * DirectoryManager::delete('directorio', false, true, true); // Delete all content except the main directory
	 * DirectoryManager::delete('directorio', true, true, true); // Delete directory and all content
	 * DirectoryManager::delete('directorio', false, true, false, 0); // Delete only all files from main directory
	 * DirectoryManager::delete('directorio', false, true, true, 60); // Delete only files from any directory with minimum 1 minute of life 
	 * DirectoryManager::delete('directorio', false, true, true, 60, array('notdelete')); // Delete ALL content except folders or files called EXACTLY "notdelete" 
	 */
	static function delete($dir, $myself = false, $deleteDirs = true, $recursive = false, $dateOld = 0, $exceptions = array(), $subdir = false) {
		// Mask for CHMOD
		umask(000);
		
		// Is not a directory
		if (!is_dir($dir) and !is_file($dir)) return true;
	
		// If is the main directory...
		if (!$subdir) {
			// If are vars incoherent...
			if ($myself and (!$deleteDirs or !$recursive or $dateOld > 0 or !empty($exceptions))) die ('The parameters given to the function of removing directories are incorrect. <br /> You may not want to delete the directory WITHOUT deleting the content.');
			
			// Adding exceptions "." (myself) and ".." (parent)
			array_push($exceptions, ".", "..");
		}
	
		if (substr($dir, -1) != "/") $dir .= "/"; // End slash if is not present
		$contenido = array_diff(scandir($dir), $exceptions); // Read all files and directories without exceptions
	
		
		if ($dateOld != 0) $time = time(); // Current time to date old
		
		foreach ($contenido as $item) {
			$target = $dir.$item; // Current directory/file
			chmod($target, 0777);
			
			if (is_dir($target)) {
				// If is a directory reload this function changing "position" to do recursivity
				// If the directory have to self delete it will do once end the next function
				if ($recursive) DirectoryManager::delete($target, $deleteDirs, $deleteDirs, $recursive, $dateOld, $exceptions, true);
			} else {
				// Is a file
				if ($dateOld == 0 or $time - filemtime($target) > $dateOld) unlink($target);
			}
		}
	
		// Deleting directory if is fully empty
		if ($myself) {
			$contenido = array_diff(scandir($dir), array(".", "..")); // Load all content dir
			if (empty($contenido)) return rmdir($dir);
		}
		return false; 
	}
	
	
}