<?php
/**
  * EpiCookie - To store, delete, read, and modify cookies
  *
  * @author Thomas Tricarico <thomas.tricarico@gmail.com>
  * @version 1.0
  * @package EpiCookie
  */

class EpiCookie
{
  private static $instance;
  private static $c_domain;
  private static $c_path = '/';
  private static $c_httponly = true;
  private static $c_secure = false;  
  const SECURE = true;
  const HTTPONLY = true;

  /*
   * set can be used to add or modify any cookie.
   * Required: $name
   * If no $expiretime, cookie time is set to 0
   * $expiretime is the absolute time (from 1970) to delete the cookie
   */
   //technically, i guess set could also be used to delete cookies, by setting $expiretime to a low number (like 1, or time()-3600)
  public function set($name, $value, $expiretime=0) {
        
    //if name is empty, just end
    if(empty($name)) {
      EpiException::raise(new EpiException("Cannot create cookie with blank name"));
    }
    elseif(empty($value)){
      EpiException::raise(new EpiException("Cannot create cookie with no value"));
    }
    else {
      //check if cookie already exists, if so, just modify the cookie
      if(isset($_COOKIE[$name])) {
        setcookie($name, $value);
      }
      //otherwise, create the cookie
      else {
        setcookie($name, $value, $expiretime, self::$c_path, self::$c_domain, self::$c_secure, self::$c_httponly);
      }
    }
    return;
  }
  
  public function get($name) {
    if(isset($_COOKIE[$name])) {
      return $_COOKIE[$name];
    }
    else {
      return null;
    }
  }
  
  public function delete($name) {
    //delete cookie
    setcookie($name, '', 1, self::$c_path, self::$c_domain);
  }

  //removes all cookies
  public function deleteAll() {
    foreach($_COOKIE as $key => $value) {
      $this->delete($key);
    }
  }

  /*
   * EpiCookie::getInstance
   */
  public static function getInstance()
  {
    if(self::$instance)
      return self::$instance;

    self::$instance = new EpiCookie;
    return self::$instance;
  }
  /*
   * To set the cookie's domain
   */
  public static function setDomain($domain) {
    self::$c_domain = $domain;
  }
  /*
   * Set the cookie's path
   */
  public static function setPath($path) {
    self::$c_path = $path;
  }

  /* Set if should only send over https
  */
  public static function setSecure($https) {
    self::$c_secure = $https;
  }
  
  /*
   * Set if http only (can't access from JavaScript)
   * default: true
   */
  public static function setHttpOnly($httponly) {
    self::$c_httponly = $httponly;
  }

  public static function setup(/* secure, httponly */) {
    $args = func_get_args();
    
  }
}

function getCookie()
{
  return EpiCookie::getInstance();
}

