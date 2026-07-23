<div class="account-settings-container layout-top-spacing">
    <div class="account-content">
        <?php if ($this->session->flashdata('success')) {?>
            <div class="col-sm-12 mt-3">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                    <span class="badge badge-pill badge-success">Success</span> 
                    <?php echo $this->session->flashdata('success');?>
                    <button type="button" class="close btnn-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php }?>
        <?php if ($this->session->flashdata('error')) {?>
            <div class="col-sm-12 mt-3">
                <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                    <span class="badge badge-pill badge-danger">Error</span> 
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php }?>
        <div class="tab-content" id="animateLineContent-4">
            <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form class="section general-info widget-content-area br-8" method="post" action="<?php echo base_url('profile-setting'); ?>" enctype="multipart/form-data">
                        <div class="info">
                            <h4 class="">General Information</h4>
                            <div class="row">
                                <div class="col-lg-11 mx-auto">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                        <div class="profile-image">
                                        
                                            <div class="img-uploader-content">
                                                <input type="file" class="filepond"
                                                    name="profile_pic" accept="image/png, image/jpeg, image/gif"/>
                                            </div>
                                            <?php
                                            if(isset($details)&&$details['profile_pic'])
                                            { ?>
                                                <img src="<?php echo base_url('uploads/profile_pic/').$details['profile_pic']; ?>" width="150">
                                            <?php } ?>
                                        </div>
                                    </div>
                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                        <div class="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">First Name</label>
                                        <input type="text" class="form-control mb-3" id="first_name" name="first_name" value="<?php echo (isset($details)&&$details['first_name'])?$details['first_name']:''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Last Name</label>
                                        <input type="text" class="form-control mb-3" id="last_name" name="last_name" value="<?php echo (isset($details)&&$details['last_name'])?$details['last_name']:''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control mb-3" id="email" name="email" placeholder="Email here" value="<?php echo (isset($details)&&$details['email'])?$details['email']:''; ?>" readonly>
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="tel" class="form-control mb-3" id="phone" name="phone" placeholder="Phone number here" value="<?php echo (isset($details)&&$details['phone'])?$details['phone']:''; ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control mb-3" id="address" placeholder="Address" name="address"><?php echo (isset($details)&&$details['address'])?$details['address']:''; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location">City</label>
                                        <input type="text" class="form-control mb-3" id="location" name="city" placeholder="City" value="<?php echo (isset($details)&&$details['city'])?$details['city']:''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control mb-3" id="state" name="state" placeholder="State" value="<?php echo (isset($details)&&$details['state'])?$details['state']:''; ?>">
                                        <!-- <select class="form-select mb-3" id="state">
                                            <option>All Countries</option>
                                            <option selected="">Select</option>
                                            <option>Chhattisgarh</option>
                                            <option>Goa</option>
                                            <option>Chennai</option>
                                            <option>Kolkata</option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profession">Role</label>
                                        <input type="text" name="role" class="form-control" value="<?php echo (isset($details)&&$details['role'])?$details['role']:''; ?>" readonly>
                                    </div>
                                </div>
                            
                                <div class="col-md-12 mt-1">
                                    <div class="form-group text-end">
                                    <input type="submit" name="profile" value="profile" class="mt-4 mb-4 btn btn-primary">
                                    </div>
                                </div>
                                    
                            </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 layout-spacing">
    <form id="social" class="section widget-content-area br-8" method="post" action="<?php echo base_url('profile-setting'); ?>">
        <h4 class="">Change Password</h4>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <!-- <input type="hidden" name="change_password" value="1"> -->
        <div class="info">
            <div class="form-group mb-4">
                <label for="particular">Current Password</label>
                <input type="password" class="form-control" name="oldpassword">
                <?php echo form_error('oldpassword','<p class="field-error">','</p>'); ?>
            </div>
            <div class="form-group mb-4">
                <label for="particular">New Password</label>
                <input type="password" class="form-control" name="password">
                <?php echo form_error('password','<p class="field-error">','</p>'); ?>
            </div>
            <div class="form-group mb-4">
                <label for="particular">Confirm-Password</label>
                <input type="password" class="form-control" name="cpassword">
                <?php echo form_error('cpassword','<p class="field-error">','</p>'); ?>
            </div>
            <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light" name="change_password" value="change_password">Change Password</button>
        </div>
    </form>
</div>
<?php if(isset($details['role_id']) && $details['role_id'] == 1) { ?>
<div class="col-xl-6 col-lg-6 col-md-6 layout-spacing">
    <form id="social" class="section widget-content-area br-8">
        <div class="info">
            <h5 class="">Delete Account</h5>
            <div class="form-group text-start">
                <button type="button" class="btn btn-danger _effect--ripple waves-effect waves-light" id="deleteaccountBtn">Delete Account</button>
            </div>
        </div>
    </form>
</div>
<?php } ?>

</div>

</div>
  
</div>

</div>
    
</div>


<?php if(isset($details['role_id']) && $details['role_id'] == 1) { ?>
<!-- Modal -->
<div id="deleteaccount" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content bg-white">
        <form action="<?php echo base_url('Profile/deleteAccount/').$id; ?>" method="post">
            <div class="modal-body">
                <p>Do you really wanna delete your account?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>

  </div>
</div>
<?php } ?>
