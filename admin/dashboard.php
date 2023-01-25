<?php
    ob_start();
    //solve the broblem of header already sent (output Buffreing Start) it restore just  output 
    session_start();
    if(isset($_SESSION['username'])){
        $pagetitle="Dashboard";
    	include "init.php";
        /*Start Dashboard page*/
        
        //number of latest users
        $numberoflatestusers=6;
        //this is the function of get latest 5 users registered
        $thelatestusers=getlatest("*","users","Userid",$numberoflatestusers);

        //number of latest items
        $numberoflatestitems=6;
        //this is the function of get latest 5 users registered
        $thelatestitems=getlatest("*","items","Item_id",$numberoflatestitems);

        $numberoflatestcomments=6;
    	?>
    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                            Total Members
                            <span><a href="members.php"><?php echo countitems('Userid','users') ?> <i class="fa fa-users"></i></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                       Pending Members
                       <span> <a href="members.php?do=Manage&page=pending">
                        <?php echo checkitem("Regstatus","users", 0) ?> <i class='fa fa-user-plus'></i></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        Total Items
                        <span><a href="items.php"><?php echo countitems('Cat_id','items') ?> <i class='fa fa-tag'></i></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        Total Comments
                        <span><a href="comments.php"><?php echo countitems('Comment_id','comments') ?> <i class='fa fa-comments'></i></a></span>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <div class="latest">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="penel panel-default">
                            
                            <div class="panel-heading">
                                <i class="fa fa-users"></i> Latest <?php echo $numberoflatestusers ?> Registerd Users
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                <?php
                                 if(!empty($thelatestusers)){
                                 foreach($thelatestusers as $user)
                                 {
                                    echo "<li>" . $user['Username'].'</li>';

                                 }
                                 }
                                 else
                                 {
                                     echo "Ther is no users to show";                                
                                 }
                                 ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="penel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tag"></i> Latest <?php echo $numberoflatestitems ?> Registerd items
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-items">
                                <?php
                                if(! empty($thelatestitems)){
                                 foreach($thelatestitems as $item)
                                 {
                                    echo "<li>" . $item['Item_name'].'</li>';
                                 }
                                 }
                                 else
                                 {
                                    echo "There is no items to show";
                                 }
                                 ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="penel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-comments"></i> Latest <?php echo $numberoflatestcomments ?> Comments
                            </div>
                            <div class="panel-body">
                                <?php
                                $stmt=$con->prepare('SELECT comments.* , users.Username from comments INNER JOIN users on users.Userid=comments.User_id ORDER BY Comment_id DESC LIMIT 6 ');
                                $stmt->execute();
                                $comments=$stmt->fetchall();
                                if(!empty($comments)){
                                foreach($comments as $comment)
                                {
                                    echo "<div class='comment-box'>";
                                    echo "<span class='member-name'>".$comment['Username']."</span>";
                                    echo "<p class='member-comment'>".$comment['Comment']."</p>";
                                    echo "</div>";
                                }
                                }else
                                {
                                    echo "There is no comments to show";
                                }
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php 
        /*End Dashboard page*/
        include $tbl."footer.php";
    	
    }
    else{
    	header("location:index.php");
    	exit();
    }
 
    ob_end_flush();
?>