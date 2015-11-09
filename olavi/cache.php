<?php
namespace olavi;

class Cache 
{
	protected $path;

	public function setCacheFile($fileName, $content)
	{	
		file_put_contents($this -> path.$fileName, $content);
	}

    public function isCacheFileValid($fileName, $ageInSeconds)
    {
    	if(file_exists($this -> path.$fileName) && filemtime($this -> path.$fileName) + $ageInSeconds > time()) {
    		return true;
    	} else {
    		return false;
    	}
    }

	public function getCacheFile($fileName, $ageInSeconds)
	{	
		try {
			if($this -> isCacheFileValid($fileName, $ageInSeconds)) {
				return simplexml_load_file($this -> path.$fileName);
			} else {
				return false;
			}
		} catch (\Exception $e){
			return false;
		}
	}

	function __construct($path)
	{
		$this -> path = $path;
	}
}