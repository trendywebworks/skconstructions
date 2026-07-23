<div class="titlebox seperator-header layout-top-spacing">
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <h1><?php echo $title; ?>
            <?php if($subtitle!='') { ?>
                - <span><?php echo $subtitle; ?></span>
            <?php } ?>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-4 text-right">
        	<?php if(isset($addlink) && $addlink!='') { ?>
            	<a href="<?php echo base_url().$addlink; ?>" class="btn btn-dark mb-2 me-4 _effect--ripple waves-effect waves-light">Add New</a>
            <?php } ?>
            <?php if(isset($listlink) && $listlink!='') { ?>
                <a href="<?php echo base_url().$listlink; ?>" class="btn btn-dark mb-2 me-4 _effect--ripple waves-effect waves-light">View List</a>
            <?php } ?>
            <?php if(isset($editlink) && $editlink!='') { ?>
                <a href="<?php echo base_url().$editlink; ?>" class="btn btn-info mb-2 me-4 _effect--ripple waves-effect waves-light">Edit</a>
            <?php } ?>
        </div>
    </div>
</div>