<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Positively Outrageous ODUS Prize Site</title>
    <link rel="stylesheet" href="css/app.css" />
    <script src="js/vendor/modernizr.js"></script>
</head>
<body>

    <div class="off-canvas-wrap" data-offcanvas>
      <div class="inner-wrap">
        <nav class="tab-bar hide-for-medium-up">
            <section class="left-small">
              <a class="left-off-canvas-toggle menu-icon"><span>OPS</span></a>
            </section>
        </nav>
            <aside class="left-off-canvas-menu">
              <ul class="off-canvas-list">
                <li><a href="index.php">Home</a></li>
                <? if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'dsl') { ?>
                <li><a href="#">Admin</a>
                 <ul>
                 	<? if ($_SESSION['level'] == 'admin') { ?>
                 		<li><a href="admin.php">Main Admin</a></li>
                 	<? } ?>
                    <li><a href="addnew.php">Add New</a></li>
                    <li><a href="index.php?award=edidel">Edit/Delete</a></li>
                    <li><a href="index.php?award=resurrect">Resurrect</a></li>
                  </ul>
                </li>
            <? } ?>
                <li><a href="#">Prizes</a>
                 <ul>
                    <li><a href="index.php?award=dodds">Dodds</a></li>
                    <li><a href="index.php?award=douglass">Douglass</a></li>
                    <li><a href="index.php?award=dulles">Dulles</a></li>
                  </ul>
                </li>
                <li><a href="https://www.princeton.edu/collegefacebook/">Tiger Book</a></li>
                <li><a href="index.php?award=pwinners">Past Winners/a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </aside>
            <a class="exit-off-canvas"></a>

    <!-- top bar code -->
    <div class="sticky">
    <nav class="top-bar show-for-medium-up" data-topbar role="navigation" data-options="sticky_on: large">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">ODUS PRIZE SITE</a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
      </ul>
      <section class="top-bar-section">
        <ul class="right">
          
          <? if ($_SESSION['level'] == 'admin') { ?>
	          <li class="has-dropdown"><a href="#">Admin</a>
	           <ul class="dropdown">
	           	<? if ($_SESSION['level'] == 'admin') { ?>
	              <li><a href="admin.php">Main Admin</a></li>
	             <? } ?>
	             <li><a href="addnew.php">Add New</a></li>
                 <li><a href="index.php?award=edidel">Edit/Delete</a></li>
                 <li><a href="index.php?award=resurrect">Resurrect</a></li>
	           </ul>
	          </li>
          <? } ?>
          <li class="has-dropdown"><a href="#">Prizes</a>
                 <ul class="dropdown">
                    <li><a href="index.php?award=dodds">Dodds</a></li>
                    <li><a href="index.php?award=douglass">Douglass</a></li>
                    <li><a href="index.php?award=dulles">Dulles</a></li>
                  </ul>
                </li>
          <li><a href="https://www.princeton.edu/collegefacebook/">Tiger Book</a></li>
          <li><a href="index.php?award=pwinners">Past Winners</li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </section>
    </nav>	
    </div>
  <header class="row">
    <? if ($award=='dodds' || $award=='douglass' || $award=='dulles') { ?>
        <div class="small-8 columns text-right">
          <h2><? echo $whatshow; ?> </h2>
        </div>
        <div class="small-4 columns text-left">
          <button class="custom-button-class" data-reveal data-reveal-id="<? echo $award; ?>">DESCRIPTION</button>
        </div>
    <? } else { ?>
      <div class="large-12 columns text-center">
       <h2><? echo $whatshow; ?> </h2></div>
    <? } ?>
      
  </header>