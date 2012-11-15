<?php
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
		if (($token === false) || ($token == $tokenValue))	{
			$result = true;
		}
		return $result;
	}
	public function validateForm($form)	{
		$name = $form[$fieldname];
		$token = $form[$fieldtoken];
		return validateToken($name, $token);
	}
	public function addToken($e = true)	{
		$name = null;
		while(!isset($name))	{
			$name = "token_" . mt_rand(0,mt_getrandmax());
			if(isset(getSession()->get($name))	{
				$name = null;
			}
		}
		$token = $this->generateToken($tokenName);
		if ($e) {
			echo "<input type=\"hidden\" name=\"$fieldname\" value=\"$name\"/>";
			echo "<input type=\"hidden\" name=\"$fieldtoken\" value=\"$token\"/>";
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
