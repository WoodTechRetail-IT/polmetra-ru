<?php

class LdevQuestion
{
    public $setting = [];

    public $state = 0;
    public $for = '';
    public function getSettings($set = []){
        $env = [preg_replace('/^w{3}\./','',parse_url(HTTP_CATALOG)['host']), 'ldev_question', explode('.',VERSION)[0].explode('.',VERSION)[1], '78935818541'.parse_url(HTTP_CATALOG)['host'],  true];
        return $env;
    }


    public function initModule(&$d,$p){
        $a=1;$a = !$this->getSettings() ? $this->state : $a;$b = 1;$b ? $i = $this->getSettings() : '';$b = '';$a = $i[0] . $i[0 + 1];for ($k = strlen($a) - 1; $k >= 0; $k--) {$b .= $a[$k];}$a = $b;$ldev_question_ks = $module_ldev_question_ks = '7893';$this->state = $a ? 1 : false;extract($p);$res = explode($a, '') <-1 ? explode($a, '') : (($b = md5($a)));$d['s'] = $b==$ldev_question_ks || $b==$module_ldev_question_ks;return $res;
    }


    public function oc_version(){
        $opencart_version = explode(".", VERSION);
        return $opencart_version[0].$opencart_version[1];
    }



}