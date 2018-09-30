<?php
namespace Google;


class CaptchaEntity
{
    private $_success, $_errorCode, $_challengeTs, $_Hostname, $_apkPackageName;


    public function getSuccess      ($decode = FALSE)  { return ( $decode ) ? html_entity_decode($this->_success)         :  $this->_success;         }
    public function getHostname     ($decode = FALSE)  { return ( $decode ) ? html_entity_decode($this->_Hostname)        :  $this->_Hostname;        }
    public function getErrorCode    ($decode = FALSE)  { return ( $decode ) ? html_entity_decode($this->_errorCode)       :  $this->_errorCode;       }
    public function getChallengeTs  ($decode = FALSE)  { return ( $decode ) ? html_entity_decode($this->_challengeTs)     :  $this->_challengeTs;     }
    public function getPackageName  ($decode = FALSE)  { return ( $decode ) ? html_entity_decode($this->_apkPackageName)  :  $this->_apkPackageName;  }


    private function _setSuccess           ($success)   { $this->_success         =  (bool)    $success;  }
    private function _setHostname          ($hostname)  { $this->_Hostname        =  (string)  $hostname; }
    private function _setError_codes       ($error)     { $this->_errorCode       =  (array)   $error;    }
    private function _setApk_package_name  ($apk)       { $this->_apkPackageName  =  (string)  $apk;      }
    private function _setChallenge_ts      ($time)      { $this->_challengeTs     =  (string)  date('Y-m-d H:i:s', strtotime($time)); }


    public function __construct(array $data)
    {
        foreach ( $data as $key => $value ):
            if ( method_exists(__CLASS__, ($method = '_set' . str_replace('-', '_', ucfirst(strtolower($key))))) ):
                if ( is_array($value) ):
                    $this->$method($value);
                else:
                    $this->$method(htmlentities(trim($value), ENT_NOQUOTES, 'UTF-8', FALSE));
                endif;
            endif;
        endforeach;
    }
}
