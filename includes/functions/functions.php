<?php
   /**
    **
    **Get categories function
    function to get categories from DB
    **
    **
    **/

    function getcat()
    {
        global $con;
        $getcat=$con->prepare("SELECT * FROM categories ORDER BY Id ASC");
        $getcat->execute();
        $cats=$getcat->fetchall();
        return $cats;
    }

   /**
    **
    **Get items function
    function to get items from DB
    **
    **
    **/

    function getitems($cat_id)
    {
        global $con;
        $getitem=$con->prepare("SELECT * FROM items WHERE CAT_ID=? ORDER BY Item_id DESC");
        $getitem->execute(array($cat_id));
        $items=$getitem->fetchall();
        return $items;
    }



/*-----------------------------------------*/
    //title of function
    function gettitle()
    {
    	global $pagetitle;
    	if(isset($pagetitle))
    	{
    		echo $pagetitle;
    	}
    	else
    	{
    		echo "Default";
    	}
    }


    //Home Redirect Function v1.0
    function redirecthome($themsg , $url= null ,$seconds = 3)
    {
        if($url === null){
            $url="index.php";
            $link="Hombage";
        }
        else
        {
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '')
            {
                $url=$_SERVER['HTTP_REFERER'];
                $link="previous page";
            }
            else
            {
                $url="index.php";
                $link="Homepage";
            }
            
        }

        echo $themsg;


        echo "<div class='alert alert-info'>". "You will be redirected to " . $link ." after " 
       . $seconds. ' second'."<div>";

        header("refresh:$seconds;url=$url");
        exit();
    }


    //function to check items in DB
    /*
    **$select variable: to select
    **$value variable : example select $select from $from where Userid = $value;
    **
    */
    function checkitem($select,$tablename,$value)
    {
        global $con;
        $statement = $con->prepare("SELECT $select FROM $tablename WHERE $select = ?");
        $statement->execute(array($value));
        $count=$statement->rowcount();
        return  $count;
    }


    //function countitems: count number of items
    /*
    **itemname:item to count
    **tablename:table to choose from it
    */
    function countitems($itemname,$tablename)
    {
        global $con;
        $stmt2=$con->prepare("SELECT COUNT($itemname) FROM $tablename");
        $stmt2->execute();
        return $stmt2->fetchcolumn();
    }


   
    //function to test (fetch,fetchall,rowcount,fetchcolumn)
    /*

    function getlatest()
    {
        global $con;
        $getstmt=$con->prepare("SELECT * FROM users");
        $getstmt->execute();
        $rows=$getstmt->fetch();

        echo "<pre>";
        print_r($rows);
        echo "</pre>";

        $count=$getstmt->rowcount();
        //$count=$getstmt->rowcount();
        return $count;
    }

    */


    /*
    **
    **Get latest records function
    function to get latest records from DB (users,items,comments)
    **
    **
    */
    function getlatest($select,$tablename,$order,$limit=5)
    {
        global $con;
        $getstmt=$con->prepare("SELECT $select FROM $tablename ORDER BY $order DESC limit $limit");
        $getstmt->execute();
        $rows=$getstmt->fetchall();
        return $rows;
    }
    

