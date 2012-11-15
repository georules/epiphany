<?php
/** 
  * EpiToken - for CSRF prevention and prevention of form resubmissions
  * 
  * Implementation based on https://www.owasp.org/index.php/PHP_CSRF_Guard
  * @author Geoffery Miller <geoffery.miller@gmail.com>
  * @version 1.0
  * @package EpiCode
  */
class EpiToken
{
	private static $fieldname = "nonce-name";
	private static $fieldtoken = "nonce-token";
	
	public function generateToken($tokenName)	{
		$token = hash("sha512",mt_rand(0,mt_getrandmax()));
		getSession()->set($tokenName, $token);
		return $token;
	}
	public function validateToken($tokenName, $tokenValue)	{
		$token = getSession()->get($tokenName);
		$result = false;
		if ($token == $tokenValue)	{
			$result = true;
			getSession()->set($tokenName,null);
		}
		return $result;
	}
	public function validateForm($form)	{
		$fname = self::$fieldname;
		$ftoken = self::$fieldtoken;
		if (empty($form[$fname]) || empty($form[$ftoken]) )
			return false;
		$name = $form[$fname];
		$token = $form[$ftoken];
		return $this->validateToken($name, $token);
	}
	public function addToken($e = true)	{
		$name = null;
		while(!isset($name))	{
			$name = "token_" . mt_rand(0,mt_getrandmax());
			$check = getSession()->get($name);
			if(!isset($check))	{
				$name = null;
			}
		}
		$token = $this->generateToken($name);
		if ($e) {
			$fname = self::$fieldname;
			$ftoken = self::$fieldtoken;
			echo "<input type=\"hidden\" name=\"$fname\" value=\"$name\"/>";
			echo "<input type=\"hidden\" name=\"$ftoken\" value=\"$token\"/>";
		}
		else	{
			$a = array("name"=>$name, "token"=>$token);
			return $a;
		}
	}
}
function getToken()
{
  static $token;
  if(!$token)
    $token = new EpiToken();

  return $token;
}
