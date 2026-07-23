<?php
    require_once('partials/header/header.php');
    require_once('partials/universal/loader.php');    
    require_once('partials/header/navbar.php');    
?>

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container " id="container">

    <?php
        require_once('partials/universal/overlay.php');    
        require_once('partials/universal/search-overlay.php');    
        require_once('partials/universal/sidebar.php');    
    ?>

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="middle-content container-xxl p-0">

                <div class="titlebox seperator-header layout-top-spacing">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <h1>Daily Reports</h1>
                        </div>
                    </div>
                </div>
                <!-- page title ends here -->

                <?php
                    require_once('partials/header/breadcrumbs.php');    
                    require_once('partials/gst-bill/list.php'); 
                ?>

            </div>
            
        </div>            

<?php require_once('partials/footer/footer.php'); ?> 