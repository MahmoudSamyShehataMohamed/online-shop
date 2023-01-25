
<nav class="navbar  navbar-expand-lg navbar-dark bg-dark">
  <!--link-->
  <div class="container">
  <a class="navbar-brand" href="dashboard.php"><?Php echo lang('home'); ?></a>
  <a class="navbar-brand" href="categories.php"><?php echo lang('categories'); ?></a>
  <a class="navbar-brand" href="items.php"><?php echo lang('items'); ?></a>
  <a class="navbar-brand" href="members.php"><?php echo lang('members'); ?></a>
  <a class="navbar-brand" href="comments.php"><?php echo lang('comments'); ?></a>
  <!--
  <a class="navbar-brand" href="#"><?php echo lang('statistic'); ?></a>
  <a class="navbar-brand" href="#"><?php echo lang('logs');?></a>
  -->

  <!--collapse-->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  
  <div class="collapse navbar-collapse" id="app_nav">
  
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo lang('mahmoud');?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php"><?php echo lang('visit shop');?></a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['id']?>"><?php echo lang('edit profile');?></a>
          <a class="dropdown-item" href="#"><?php echo lang('settings');?></a>
          <a class="dropdown-item" href="logout.php"><?php echo lang('logout');?></a>
        </div>
      </li>

    </ul>

  </div>
  </div>
</nav>






