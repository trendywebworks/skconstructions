<style>
    .daily-expense-card .daily-expense-content {
        padding: 0 16px 16px;
    }
    .daily-expense-card .daily-expense-detail {
        min-width: 0;
        overflow-wrap: anywhere;
    }
	    .daily-expense-card .daily-expense-amount {
	        flex-shrink: 0;
	        margin-left: 12px;
	    }
	    .dashboard-summary-card .widget-heading {
	        margin-bottom: 24px;
	    }
	    .dashboard-summary-card .widget-content .summary-list:not(:last-child) {
	        margin-bottom: 18px;
	    }
	    .dashboard-summary-card .widget-content .w-icon {
	        align-items: center;
	        justify-content: center;
	    }
	    .dashboard-summary-card .summary-icon-text {
	        font-size: 12px;
	        font-weight: 700;
	        line-height: 1;
	    }
	</style>

<div class="row layout-top-spacing">

    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h5 class="">Revenue</h5>
                <div class="task-action">
                    <div class="dropdown">
                        <!-- <a class="dropdown-toggle" href="#" role="button" id="renvenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu left" aria-labelledby="renvenue" style="will-change: transform;">
                            <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                            <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                            <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="widget-content">
                <input type="hidden" name="monthlyTotalIncome" id="monthlyTotalIncome" value="<?php echo $monthlyTotalIncome; ?>">
                <input type="hidden" name="monthlyTotalExpenses" id="monthlyTotalExpenses" value="<?php echo $monthlyTotalExpenses; ?>">
                <div id="revenueMonthly"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-two">
            <div class="widget-heading">
                <h5 class="">Total Expense</h5>
            </div>
            <div class="widget-content">
                <input type="hidden" name="daily_expense" id="daily_expense" value="<?php echo $allExpenses['daily_expense']; ?>">
                <input type="hidden" name="vehicle_expense" id="vehicle_expense" value="<?php echo $allExpenses['vehicle_expense']; ?>">
                <input type="hidden" name="office_expense" id="office_expense" value="<?php echo $allExpenses['office_expense']; ?>">
                <div id="chart-2" class=""></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        <div class="widget-two daily-expense-card">
            <div class="widget-content">
                <div class="w-numeric-value">
                    <div class="w-content">
                        <span class="w-value">Daily Entry</span>
                    </div>
                    <div class="w-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                </div>
                <div class="daily-expense-content">
                    <input type="hidden" name="daily_profit" id="daily_profit" value="<?php echo $daily_expense['profit']; ?>">
                    <input type="hidden" name="daily_lose" id="daily_lose" value="<?php echo $daily_expense['lose']; ?>">
                    <div id="daily-sales" class="d-none"></div>
                    <div class="daily-expense-list">
                        <?php if(isset($latestDailyExpenses) && count($latestDailyExpenses) > 0) { ?>
                            <?php foreach($latestDailyExpenses as $dailyExpense) { ?>
                                <div class="d-flex align-items-start justify-content-between py-2 border-bottom">
                                    <div class="daily-expense-detail">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($dailyExpense['particular'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                        <p class="mb-0 text-muted">
                                            <?php echo commonDateFormat($dailyExpense['entry_date']); ?>
                                            <?php if(!empty($dailyExpense['site'])) { ?>
                                                &middot; <?php echo htmlspecialchars($dailyExpense['site'], ENT_QUOTES, 'UTF-8'); ?>
                                            <?php } ?>
                                        </p>
                                        <?php if(!empty($dailyExpense['remarks'])) { ?>
                                            <p class="mb-0 text-muted"><?php echo htmlspecialchars($dailyExpense['remarks'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="daily-expense-amount text-end">
                                        <p class="mb-1 text-danger fw-bold"><?php echo numFormat($dailyExpense['amount']); ?></p>
                                        <span class="badge badge-light-<?php echo ($dailyExpense['status'] == 'active')?'success':'warning'; ?>"><?php echo ucfirst($dailyExpense['status']); ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                            <a href="<?php echo base_url(); ?>daily-entry-list" class="d-inline-block mt-3">View All</a>
                        <?php } else { ?>
                            <p class="mb-0 text-muted">No daily expense entries found.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

	    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
	        <div class="widget widget-three dashboard-summary-card">
	            <div class="widget-heading">
	                <h5 class="">Summary</h5>

                <div class="task-action">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="summary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>

	                        <div class="dropdown-menu left" aria-labelledby="summary" style="will-change: transform;">
	                            <a class="dropdown-item" href="<?php echo base_url(); ?>daily-entry-list">Daily Expense</a>
	                            <a class="dropdown-item" href="<?php echo base_url(); ?>cc-account-list">CC Account Loans</a>
	                            <a class="dropdown-item" href="<?php echo base_url(); ?>market-loans-list">Market Loans</a>
	                            <a class="dropdown-item" href="<?php echo base_url(); ?>staff-loans-list">Staff Loans</a>
	                            <a class="dropdown-item" href="<?php echo base_url(); ?>purchase-list">Purchase</a>
	                            <!-- <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a> -->
	                        </div>
                    </div>
                </div>

            </div>
	            <div class="widget-content">

	                <div class="order-summary">
	                    <?php
	                    $summaryCards = array(
	                        array('label' => 'Profit', 'value' => $summary['profit'], 'abbr' => 'P', 'bar' => ($summary['profit'] >= 0)?'bg-gradient-success':'bg-gradient-danger', 'bg' => '#eafaf1', 'color' => '#1abc9c'),
	                        array('label' => 'Income', 'value' => $summary['income'], 'abbr' => 'I', 'bar' => 'bg-gradient-info', 'bg' => '#eaf3ff', 'color' => '#2196f3'),
	                        array('label' => 'Expenses', 'value' => $summary['lose'], 'abbr' => 'E', 'bar' => 'bg-gradient-warning', 'bg' => '#fcf5e9', 'color' => '#e2a03f'),
	                        array('label' => 'Purchase', 'value' => $summary['purchase'], 'abbr' => 'PU', 'bar' => 'bg-gradient-primary', 'bg' => '#f2eafa', 'color' => '#805dca'),
	                        array('label' => 'Loans', 'value' => $summary['loan'], 'abbr' => 'L', 'bar' => 'bg-gradient-secondary', 'bg' => '#f1f2f3', 'color' => '#515365'),
	                        array('label' => 'Vehicle Expenses', 'value' => $summary['vehicle_expense'], 'abbr' => 'V', 'bar' => 'bg-gradient-danger', 'bg' => '#fff5f5', 'color' => '#e7515a'),
	                        array('label' => 'Office Expenses', 'value' => $summary['office_expense'], 'abbr' => 'O', 'bar' => 'bg-gradient-dark', 'bg' => '#f3f5f8', 'color' => '#3b3f5c')
	                    );
	                    ?>
	                    <?php foreach($summaryCards as $summaryCard) { ?>
	                        <?php
	                            $summaryValue = (float)$summaryCard['value'];
	                            $summaryPercentage = (isset($summary['plltotal']) && $summary['plltotal'] > 0)?(abs($summaryValue)/$summary['plltotal']) * 100:0;
	                        ?>
	                        <div class="summary-list">
	                            <div class="w-icon" style="background: <?php echo $summaryCard['bg']; ?>; color: <?php echo $summaryCard['color']; ?>;">
	                                <span class="summary-icon-text"><?php echo $summaryCard['abbr']; ?></span>
	                            </div>
	                            <div class="w-summary-details">
	                                <div class="w-summary-info">
	                                    <h6><?php echo $summaryCard['label']; ?></h6>
	                                    <p class="summary-count"><?php echo numFormat($summaryValue); ?></p>
	                                </div>

	                                <div class="w-summary-stats">
	                                    <div class="progress">
	                                        <div class="progress-bar <?php echo $summaryCard['bar']; ?>" role="progressbar" style="width: <?php echo floor($summaryPercentage); ?>%" aria-valuenow="<?php echo floor($summaryPercentage); ?>" aria-valuemin="0" aria-valuemax="100"></div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    <?php } ?>
	                    
	                </div>
                
            </div>
        </div>
    </div>

	    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
	        <div class="widget-one widget">
	            <div class="widget-content">
                <div class="w-numeric-value">
                    <div class="w-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    </div>
                    <div class="w-content">
                        <span class="w-value">₹<?php echo (isset($cctotal))?number_format($cctotal, 0):0; ?></span>
                        <span class="w-numeric-title">Total CC Account Loans</span>
                    </div>
                </div>
                <div class="w-chart">
                    <div id="total-orders"></div>
                </div>
            </div>
	        </div>
	    </div>

	    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
	        <div class="widget-one widget">
	            <div class="widget-content">
	                <div class="w-numeric-value">
	                    <div class="w-icon">
	                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
	                    </div>
	                    <div class="w-content">
	                        <span class="w-value">₹<?php echo (isset($summary['staff_loan']))?number_format($summary['staff_loan'], 0):0; ?></span>
	                        <span class="w-numeric-title">Total Staff Loans</span>
	                    </div>
	                </div>
	                <div class="w-chart">
	                    <div id="total-staff-loans"></div>
	                </div>
	            </div>
	        </div>
	    </div>

	</div>
