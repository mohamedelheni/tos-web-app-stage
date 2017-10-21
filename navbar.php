<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><img src="..\tos.PNG" style="max-width:80px; position:relative; top:-10px;" /></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="services.php"><?php echo lang('CATEGORIES') ?></a></li>
        
        <li><a href="members.php"><?php echo lang('MEMBERS') ?></a></li>
        
        <li><a href="sav.php"><?php echo lang('SAV') ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit</a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Modifier Profile</a></li>
            <li><a href="logout.php">Sortir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>