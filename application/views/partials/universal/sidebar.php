<?php
    $mylink = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$mylink);

    $lastpart = end($link_array);
    $secondLastPart = $link_array[count($link_array) - 2];

    $userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
    $role_id = $userdata['role_id'];
    $userPermissions = $this->Role_model->getRolePermissionsName($role_id);
    $permissions = array_column($userPermissions, 'role_name');
?>
<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="index">
                        <img src="src/assets/img/logo.svg" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="index" class="nav-link"> SK Constructions </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('dashboard'))) { echo 'active'; } ?>">
                <a href="dashboard" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </div>                            
                </a>                        
            </li>

            <?php if (!empty(array_intersect(['daily-entry-list', 'daily-entry-add', 'daily-entry-edit', 'daily-entry-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('daily-entry-list', 'daily-entry-add', 'daily-entry-edit/'.$lastpart, 'daily-entry-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#apps" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Daily Entry</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('daily-entry-list', 'daily-entry-add', 'daily-entry-edit/'.$lastpart, 'daily-entry-view/'.$lastpart))) { echo 'show'; } ?>" id="apps" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['daily-entry-list', 'daily-entry-edit', 'daily-entry-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>daily-entry-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['daily-entry-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>daily-entry-add">Add New</a>
                        </li>      
                    <?php } ?>                      
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['site-expenses'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('site-expenses'))) { echo 'active'; } ?>">
                <a href="#sitesexp" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Site Expenses</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('site-expenses'))) { echo 'show'; } ?>" id="sitesexp" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['site-expenses'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>site-expenses">Site Expenses</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['pay-partner-list', 'pay-partner-add', 'pay-partner-edit', 'pay-partner-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('pay-partner-list', 'pay-partner-add', 'pay-partner-edit/'.$lastpart, 'pay-partner-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#paypartner" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Partner Payments</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('pay-partner-list', 'pay-partner-add', 'pay-partner-edit/'.$lastpart, 'pay-partner-view/'.$lastpart))) { echo 'show'; } ?>" id="paypartner" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['pay-partner-list', 'pay-partner-edit', 'pay-partner-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>pay-partner-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['pay-partner-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>pay-partner-add">Add New</a>
                        </li>  
                    <?php } ?>                          
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['market-loans-list', 'market-loans-add', 'market-loans-edit', 'market-loans-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('market-loans-list', 'market-loans-add', 'market-loans-edit/'.$lastpart, 'market-loans-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#marketloans" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-umbrella"><path d="M23 12a11.05 11.05 0 0 0-22 0zm-5 7a3 3 0 0 1-6 0v-7"></path></svg>
                        <span>Market Loans</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('market-loans-list', 'market-loans-add', 'market-loans-edit/'.$lastpart, 'market-loans-view/'.$lastpart))) { echo 'show'; } ?>" id="marketloans" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['market-loans-list', 'market-loans-edit', 'market-loans-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>market-loans-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['market-loans-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>market-loans-add">Add New</a>
                        </li> 
                    <?php } ?>                           
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['vehicles-expenses-list', 'vehicles-expense-add', 'vehicles-expense-edit', 'vehicles-expense-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('vehicles-expenses-list', 'vehicles-expense-add', 'vehicles-expense-edit/'.$lastpart, 'vehicles-expense-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#vehiclefinance" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Vehicle Expenses</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('vehicles-expenses-list', 'vehicles-expense-add', 'vehicles-expense-edit/'.$lastpart, 'vehicles-expense-view/'.$lastpart))) { echo 'show'; } ?>" id="vehiclefinance" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['vehicles-expenses-list', 'vehicles-expense-edit', 'vehicles-expense-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>vehicles-expenses-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['vehicles-expense-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>vehicles-expense-add">Add New</a>
                        </li>   
                    <?php } ?>                         
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['vehicles-running-list', 'vehicles-running-add', 'vehicles-running-edit', 'vehicles-running-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('vehicles-running-list', 'vehicles-running-add', 'vehicles-running-edit/'.$lastpart, 'vehicles-running-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#vehiclerunning" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Vehicle Running KM</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('vehicles-running-list', 'vehicles-running-add', 'vehicles-running-edit/'.$lastpart, 'vehicles-running-view/'.$lastpart))) { echo 'show'; } ?>" id="vehiclerunning" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['vehicles-running-list', 'vehicles-running-edit', 'vehicles-running-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>vehicles-running-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['vehicles-running-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>vehicles-running-add">Add New</a>
                        </li>    
                    <?php } ?>                        
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['purchase-list', 'purchase-add', 'purchase-edit', 'purchase-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('purchase-list', 'purchase-add', 'purchase-edit/'.$lastpart, 'purchase-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#purchase" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Purchase</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('purchase-list', 'purchase-add', 'purchase-edit/'.$lastpart, 'purchase-view/'.$lastpart))) { echo 'show'; } ?>" id="purchase" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['purchase-list', 'purchase-edit', 'purchase-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>purchase-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['purchase-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>purchase-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['gst-bill-list', 'gst-bill-add', 'gst-bill-edit', 'gst-bill-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('gst-bill-list', 'gst-bill-add', 'gst-bill-edit/'.$lastpart, 'gst-bill-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#gstbill" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>GST Bill</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('gst-bill-list', 'gst-bill-add', 'gst-bill-edit/'.$lastpart, 'gst-bill-view/'.$lastpart))) { echo 'show'; } ?>" id="gstbill" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['gst-bill-list', 'gst-bill-edit', 'gst-bill-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>gst-bill-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['gst-bill-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>gst-bill-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['fdr-list', 'fdr-add', 'fdr-edit', 'fdr-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('fdr-list', 'fdr-add', 'fdr-edit/'.$lastpart, 'fdr-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#fdr" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>FDR</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('fdr-list', 'fdr-add', 'fdr-edit/'.$lastpart, 'fdr-view/'.$lastpart))) { echo 'show'; } ?>" id="fdr" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['fdr-list', 'fdr-edit', 'fdr-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>fdr-list">View List</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty(array_intersect(['fdr-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>fdr-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['cc-account-list', 'cc-account-add', 'cc-account-edit', 'cc-account-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('cc-account-list', 'cc-account-add', 'cc-account-edit/'.$lastpart, 'cc-account-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#ccaccount" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span>CC Account</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('cc-account-list', 'cc-account-add', 'cc-account-edit/'.$lastpart, 'cc-account-view/'.$lastpart))) { echo 'show'; } ?>" id="ccaccount" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['cc-account-list', 'cc-account-add', 'cc-account-edit', 'cc-account-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>cc-account-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['cc-account-list', 'cc-account-add', 'cc-account-edit', 'cc-account-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>cc-account-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['products-list', 'product-add', 'product-edit', 'product-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('products-list', 'product-add', 'product-edit/'.$lastpart, 'product-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#products" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                        <span>Products</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('products-list', 'product-add', 'product-edit/'.$lastpart, 'product-view/'.$lastpart))) { echo 'show'; } ?>" id="products" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['products-list', 'product-edit', 'product-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>products-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['product-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>product-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['office-expense-list', 'office-expense-add', 'office-expense-edit', 'office-expense-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('office-expense-list', 'office-expense-add', 'office-expense-edit/'.$lastpart, 'office-expense-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#officeexpense" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                        <span>Office Expense</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('office-expense-list', 'office-expense-add', 'office-expense-edit/'.$lastpart, 'office-expense-view/'.$lastpart))) { echo 'show'; } ?>" id="officeexpense" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['office-expense-list', 'office-expense-edit', 'office-expense-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>office-expense-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['office-expense-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>office-expense-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['staff-loans-list', 'staff-loan-add', 'staff-loan-edit', 'staff-loan-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('staff-loans-list', 'staff-loan-add', 'staff-loan-edit/'.$lastpart, 'staff-loan-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#staffloans" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-repeat"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                        <span>Staff Loans</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('staff-loans-list', 'staff-loan-add', 'staff-loan-edit/'.$lastpart, 'staff-loan-view/'.$lastpart))) { echo 'show'; } ?>" id="staffloans" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['staff-loans-list', 'staff-loan-edit', 'staff-loan-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>staff-loans-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['staff-loan-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>staff-loan-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['reports', 'reports-monthly', 'reports-daily', 'cashflow-reports'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('reports', 'reports-monthly', 'reports-monthly/'.$lastpart, 'reports-daily', 'reports-daily/'.$secondLastPart.'/'.$lastpart, 'cashflow-reports'))) { echo 'active'; } ?>">
                <a href="#reports" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                        <span>Reports</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('reports', 'reports-monthly', 'reports-monthly/'.$lastpart, 'reports-daily', 'reports-daily/'.$secondLastPart.'/'.$lastpart, 'cashflow-reports'))) { echo 'show'; } ?>" id="reports" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['reports-daily'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports-daily">Daily Reports</a>
                        </li>
                    <?php } if (!empty(array_intersect(['reports-monthly'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports-monthly">Monthly Reports</a>
                        </li>
                    <?php } if (!empty(array_intersect(['reports'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports">Reports</a>
                        </li>
                    <?php }  if (!empty(array_intersect(['cashflow-reports'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>cashflow-reports">Cashflow Reports</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['sites-list', 'site-add', 'site-edit', 'site-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('sites-list', 'site-add', 'site-edit/'.$lastpart, 'site-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#sites" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Sites</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('sites-list', 'site-add', 'site-edit/'.$lastpart, 'site-view/'.$lastpart))) { echo 'show'; } ?>" id="sites" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['sites-list', 'site-edit', 'site-view'], $permissions))){ ?>
                        <li>
                             <a href="<?php echo base_url(); ?>sites-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['site-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>site-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['partners-list', 'partner-add', 'partner-edit', 'partner-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('partners-list', 'partner-add', 'partner-edit/'.$lastpart, 'partner-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#partners" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Partners</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('partners-list', 'partner-add', 'partner-edit/'.$lastpart, 'partner-view/'.$lastpart))) { echo 'show'; } ?>" id="partners" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['partners-list', 'partner-edit', 'partner-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>partners-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['partner-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>partner-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['vehicles-list', 'vehicle-add', 'vehicle-edit', 'vehicle-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('vehicles-list', 'vehicle-add', 'vehicle-edit/'.$lastpart, 'vehicle-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#vehicles" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Vehicles</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('vehicles-list', 'vehicle-add', 'vehicle-edit/'.$lastpart, 'vehicle-view/'.$lastpart))) { echo 'show'; } ?>" id="vehicles" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['vehicles-list', 'vehicle-edit', 'vehicle-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>vehicles-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['vehicle-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>vehicle-add">Add New</a>
                        </li>  
                    <?php } ?>                          
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['office-staff-list', 'office-staff-add', 'office-staff-edit', 'office-staff-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('office-staff-list', 'office-staff-add', 'office-staff-edit/'.$lastpart, 'office-staff-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#officestaff" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                        <span>Office Staff</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('office-staff-list', 'office-staff-add', 'office-staff-edit/'.$lastpart, 'office-staff-view/'.$lastpart))) { echo 'show'; } ?>" id="officestaff" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['office-staff-list', 'office-staff-edit', 'office-staff-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>office-staff-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['office-staff-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>office-staff-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li> 
            <?php } ?>

            <?php if (!empty(array_intersect(['loan-party-list', 'loan-party-add', 'loan-party-edit', 'loan-party-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('loan-party-list', 'loan-party-add', 'loan-party-edit/'.$lastpart, 'loan-party-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#loanparty" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        <span>Loan Party</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('loan-party-list', 'loan-party-add', 'loan-party-edit/'.$lastpart, 'loan-party-view/'.$lastpart))) { echo 'show'; } ?>" id="loanparty" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['loan-party-list', 'loan-party-edit', 'loan-party-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>loan-party-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['loan-party-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>loan-party-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['expense-type-list', 'expense-type-add', 'expense-type-edit', 'expense-type-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('expense-type-list', 'expense-type-add', 'expense-type-edit/'.$lastpart, 'expense-type-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#expensetype" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cloud-drizzle"><line x1="8" y1="19" x2="8" y2="21"></line><line x1="8" y1="13" x2="8" y2="15"></line><line x1="16" y1="19" x2="16" y2="21"></line><line x1="16" y1="13" x2="16" y2="15"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="12" y1="15" x2="12" y2="17"></line><path d="M20 16.58A5 5 0 0 0 18 7h-1.26A8 8 0 1 0 4 15.25"></path></svg>
                        <span>Cashflow</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('expense-type-list', 'expense-type-add', 'expense-type-edit/'.$lastpart, 'expense-type-view/'.$lastpart))) { echo 'show'; } ?>" id="expensetype" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['expense-type-list', 'expense-type-edit', 'expense-type-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>expense-type-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['expense-type-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>expense-type-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['suppliers-list', 'supplier-add', 'supplier-edit', 'supplier-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('suppliers-list', 'supplier-add', 'supplier-edit/'.$lastpart, 'supplier-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#suppliers" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Suppliers</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('suppliers-list', 'supplier-add', 'supplier-edit/'.$lastpart, 'supplier-view/'.$lastpart))) { echo 'show'; } ?>" id="suppliers" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['suppliers-list', 'supplier-edit', 'supplier-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>suppliers-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['supplier-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>supplier-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['banks-list', 'bank-add', 'bank-edit', 'bank-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('banks-list', 'bank-add', 'bank-edit/'.$lastpart, 'bank-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#banks" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-anchor"><circle cx="12" cy="5" r="3"></circle><line x1="12" y1="22" x2="12" y2="8"></line><path d="M5 12H2a10 10 0 0 0 20 0h-3"></path></svg>
                        <span>Banks</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('banks-list', 'bank-add', 'bank-edit/'.$lastpart, 'bank-view/'.$lastpart))) { echo 'show'; } ?>" id="banks" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['banks-list', 'bank-edit', 'bank-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>banks-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['bank-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>bank-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['users-list', 'user-add', 'user-edit', 'user-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('users-list', 'user-add', 'user-edit/'.$lastpart, 'user-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#users" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Users</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('users-list', 'user-add', 'user-edit/'.$lastpart, 'user-view/'.$lastpart))) { echo 'show'; } ?>" id="users" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['users-list', 'user-edit', 'user-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>users-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['user-add'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>user-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (!empty(array_intersect(['user-role-list', 'user-role-add', 'user-role-edit', 'user-role-view'], $permissions))){ ?>
            <li class="menu <?php if(in_array($this->uri->uri_string(), array('user-role-list', 'user-role-add', 'user-role-edit/'.$lastpart, 'user-role-view/'.$lastpart))) { echo 'active'; } ?>">
                <a href="#userroles" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>User Roles</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('user-role-list', 'user-role-add', 'user-role-edit/'.$lastpart, 'user-role-view/'.$lastpart))) { echo 'show'; } ?>" id="userroles" data-bs-parent="#accordionExample">
                    <?php if (!empty(array_intersect(['user-role-list', 'user-role-add', 'user-role-edit', 'user-role-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>user-role-list">View List</a>
                        </li>
                    <?php } if (!empty(array_intersect(['user-role-list', 'user-role-add', 'user-role-edit', 'user-role-view'], $permissions))){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>user-role-add">Add New</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>                                    
            <?php } ?>

            <li class="menu <?php if(in_array($this->uri->uri_string(), array('profile-setting'))) { echo 'active'; } ?>">
                <a href="#profile" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                        <span>Profile</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php if(in_array($this->uri->uri_string(), array('profile-setting'))) { echo 'show'; } ?>" id="profile" data-bs-parent="#accordionExample">
                    <li>
                        <a href="<?php echo base_url(); ?>profile-setting">Settings</a>
                    </li>
                </ul>
            </li>  
            

            <li class="menu">
                <div style="width:100%; height: 250px;"></div>
            </li>


        </ul>
        
    </nav>

</div>
<!--  END SIDEBAR  -->