<?php

/**
 * @Author: anwar
 * @Date:   2017-11-21 00:10:00
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-11-21 11:13:23
 */
namespace App\Traits;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
 * summary
 */
trait SmsTrait
{
    /**
     * summary
     */
    public function sms($rcver,$sender,$message,$ac=null,$pw=null)
    {
        $baseurl  = "http://smsserver.pixie.se/sendsms?";
        $account  = "account=11711686";
        $password = "pwd=KwVNOmEL";
        $reciver  = "receivers=".$rcver;
        $sender   = "sender=".$sender;
        $message  = "message=".$message;

        $url  = $baseurl.$account."&".$password."&".$reciver."&".$sender."&".$message;

        return $this->sendsms($url);

        //http://smsserver.pixie.se/sendsms?account=11711686&pwd=KwVNOmEL&receivers=+8801676091639&sender=123&message=yourmessage
    }

    private function sendsms($url)
    {
    	$client = new Client();
    	return $client->get($url);
    	
    }

}