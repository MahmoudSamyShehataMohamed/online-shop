<?php 
    function lang($phrase){
    	static $lang = array(
    		'home'       =>"Homepage",
    		'categories' =>'Categories',
    		'mahmoud'    =>'Mahmoud',
    		'items'      =>'Items',
    		'members'    =>'Members',/*
    		'statistic' =>'Statistics',
    		'logs'       =>'Logs',*/
    		'edit profile'=>'Edit Profile',
    		'logout'=>'Logout',
    		'settings'=>'Settings',
    		'comments'=>'Comments',
    		''=>'',
    	);

    	return $lang[$phrase];

    }