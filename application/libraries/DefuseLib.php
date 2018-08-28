<?php 

use Defuse\Crypto\Key as DefuseKey;

use Defuse\Crypto\Crypto as DefuseCrypto;

use Defuse\Crypto\KeyProtectedByPassword as DefusePassword;

class DefuseLib  {

	const bytes 	= '80bef0124333e514677752767d69fc8a';
	const path 		= '../generate-key.txt';
	
	public static function getConfig(){

		$keyAscii = file_get_contents(self::path, FILE_USE_INCLUDE_PATH);

    	return DefuseKey::loadFromAsciiSafeString($keyAscii);
	}

	public static function generateKey(){
		return  DefuseKey::createNewRandomKey()->saveToAsciiSafeString();
	}

	public static function encrypt($string){
		$key 	= self::getConfig();
		$result = DefuseCrypto::encrypt($string, $key);
		return $result;
	}

	public static function decrypt($string){

		$key 	= self::getConfig();		

		try {
    		$secret_data = DefuseCrypto::decrypt($string, $key);
    		return $secret_data;
		} catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
		    return;
		}
	}

}