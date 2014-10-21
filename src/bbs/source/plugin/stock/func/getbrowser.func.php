<?php
/**
 * PHP识别主流浏览器。
 * 
 * @author 创想编程（TOPPHP.ORG）
 * @copyright Copyright (c) 2013 创想编程（TOPPHP.ORG） All Rights Reserved
 * @license http://www.opensource.org/licenses/mit-license.php MIT LICENSE
 * @version 1.0.0 - Build20130728
 */
final class Browser {
  /**
   * 主流浏览器标识。
   * 
   * @var boolean
   */
  private $isFirefox = FALSE;
  private $isIE = FALSE;
  private $isOpera = FALSE;
  private $isChrome = FALSE;
  private $isSafari = FALSE;
 
  /**
   * 当前浏览器User-Agent。
   * 
   * @var string
   */
  private $userAgent = 'Unknow';
 
  /**
   * 当前浏览器名称。
   * 
   * @var string
   */
  private $name = 'Unknow';
 
  /**
   * 当前浏览器版本号。
   * 
   * @var string
   */
  private $version = 'Unknow';
 
  /**
   * 构造方法 - 初始化数据。
   */
  public function __construct() {
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
      $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
    }
 
    $this->initialize();
  }
 
  /**
   * 分析当前浏览器User-Agent信息。
   */
  private function initialize() {
    $firefoxPattern = '/Firefox\/(\d+(?:\.\d+)*)/i';
    $iePattern = '/MSIE (\d+(?:\.\d+)*)/i';
    $operaPattern = '/Opera/i';
    $chromePattern = '/Chrome\/(\d+(?:\.\d+)*)/i';
    $safariPattern = '/Safari/i';
    $versionPattern = '/Version\/(\d+(?:\.\d+)*)/';
 
    if (preg_match($firefoxPattern, $this->userAgent, $matches)) {
      $this->isFirefox = TRUE;
      $this->name = 'Firefox';
      $this->version = trim($matches[1]);
    }
    elseif (preg_match($iePattern, $this->userAgent, $matches)) {
      $this->isIE = TRUE;
      $this->name = 'IE';
      $this->version = trim($matches[1]);
    }
    elseif (preg_match($operaPattern, $this->userAgent)) {
      $this->isOpera = TRUE;
      $this->name = 'Opera';
 
      if (preg_match($versionPattern, $this->userAgent, $matches)) {
        $this->version = trim($matches[1]);
      }
    }
    elseif (preg_match($chromePattern, $this->userAgent, $matches)) {
      $this->isChrome = TRUE;
      $this->name = 'Chrome';
      $this->version = trim($matches[1]);
    }
    elseif (preg_match($safariPattern, $this->userAgent)) {
      $this->isSafari = TRUE;
      $this->name = 'Safari';
 
      if (preg_match($versionPattern, $this->userAgent, $matches)) {
        $this->version = trim($matches[1]);
      }
    }
  }
 
  /**
   * 获取当前浏览器User-Agent。
   * 
   * @return string
   */
  public function getUserAgent() {
    return $this->userAgent;
  }
 
  /**
   * 判断当前浏览器是否为Firefox。
   * 
   * @return boolean
   */
  public function isFirefox() {
    return $this->isFirefox;
  }
 
  /**
   * 判断当前浏览器是否为IE。
   * 
   * @return boolean
   */
  public function isIE() {
    return $this->isIE;
  }
 
  /**
   * 判断当前浏览器是否为Opera。
   * 
   * @return boolean
   */
  public function isOpera() {
    return $this->isOpera;
  }
 
  /**
   * 判断当前浏览器是否为Chrome。
   * 
   * @return boolean
   */
  public function isChrome() {
    return $this->isChrome;
  }
 
  /**
   * 判断当前浏览器是否为Safari。
   * 
   * @return boolean
   */
  public function isSafari() {
    return $this->isSafari;
  }
 
  /**
   * 获取当前浏览器名称。
   * 
   * @return string
   */
  public function getName() {
    return $this->name;
  }
 
  /**
   * 获取当前浏览器版本号。
   * 
   * @return string
   */
  public function getVersion() {
    return $this->version;
  }
}

/* 应用范例
$browser = new Browser();
echo $browser->getName(), ': ', $browser->getVersion();
if ($browser->isIE()){
     echo "IE ";
}else{
     echo "   NO ie";
}
*/

?>