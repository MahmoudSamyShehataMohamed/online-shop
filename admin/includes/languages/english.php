<?php 
    function lang($phrase){
    	static $lang = array(
    		'home'       =>"Home",
    		'categories' =>'Categories',
    		'mahmoud'    =>'Mahmoud',
    		'items'      =>'Items',
    		'members'    =>'Members',/*
    		'statistic' =>'Statistics',
    		'logs'       =>'Logs',*/
    		'edit profile'=>'Edit Profile',
            'visit shop' => 'Visit Shop',
    		'logout'=>'Logout',
    		'settings'=>'Settings',
    		'comments'=>'Comments',
    		''=>'',
    	);

    	return $lang[$phrase];

    }