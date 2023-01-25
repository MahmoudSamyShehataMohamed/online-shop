<?php 
    function lang($phrase){
    	static $lang = array(

    		"home" => "الصفحة الرئيسية",
    		"categories" => "التصنيفات",
    		"mahmoud"=>"محمود",
    		"items"=>"العناصر",
    		"members"=>"الأعضاء",
    		"logout"=>"تسجيل الخروخ",
    		"statistic"=>"الأحصائيات",
    		"logs"=>"التسجيلات",
    		"edit profile"=>"تعديل البروفايل",
    		"settings"=>"الاعدادات",
    		"comments"=>"التعليقات",
    	);

    	return $lang[$phrase];

    }