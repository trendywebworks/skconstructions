<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div class="info">
                        <h4 class=""></h4>
                        <div class="row">
                            <div class="col-lg-11 mx-auto">
                                <div class="row">
                                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="fullName">Role</label>
                                                        <br>
                                                        <?php echo (isset($list[0]))?$list[0]['name']:''; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="fullName">Permissions</label>
                                                        <br>
                                                        <ul>
                                                        <?php 
                                                        if(isset($list)) 
                                                        {
                                                            foreach($list as $li)
                                                            {
                                                                $role_label = ucwords(str_replace('-', ' ', $li['role_name']));
                                                                echo '<li>'.$role_label.'</li>';
                                                            }
                                                        }?>
                                                        </ul>
                                                    </div>
                                                </div>                                          
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>