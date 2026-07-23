<?php
    require_once('partials/header/header.php');
    require_once('partials/universal/loader.php');    
    require_once('partials/header/navbar.php');    
?>
  
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
        
    <?php
        require_once('partials/universal/overlay.php');    
        require_once('partials/universal/search-overlay.php');    
        require_once('partials/universal/sidebar.php');    
    ?>

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="middle-content container-xxl p-0">

                <?php 
                    $this->load->view('partials/header/title', $titles); 
                    $this->load->view('partials/header/breadcrumbs', $titles);    
                ?>
                <?php
            		$this->load->view($page, $titles);
            	?>

            </div>
    
        </div> 

    <?php require_once('partials/footer/footer.php'); ?>