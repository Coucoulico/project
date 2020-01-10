<?php
 


class MonthOfYear  { 
    const MONTHS=[1=>"janvier","fevrier","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","decembre"];


    public static function affiche(){
        print_r(self::MONTHS);
    }
    public static function exist($name,$strict=false){
        if(!$strict) return in_array(mb_strtolower($name), self::MONTHS);
        else return in_array($name, self::MONTHS);
    }

    public static function valueOf($month){
        if (self::exist($month)){
            $m=self::MONTHS;
            foreach($m as $key => $value){
                if(strtolower($month)===$value)  return $key;
        }
        }
    }

    public static function MonthOf($index){
        if($index<=12 && $index>=1) return self::MONTHS[$index];
    }


}





