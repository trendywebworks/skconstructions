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
                <h5 class="">Expenses - <?php echo date('Y'); ?></h5>
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
                        <span class="w-value">Daily Expenses</span>
                        <span class="w-numeric-title">Go to columns for details.</span>
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
        <div class="widget widget-three">
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
                            <!-- <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a> -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="widget-content">

                <div class="order-summary">

                    <div class="summary-list">
                        <div class="w-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                        </div>
                        <div class="w-summary-details">
                            
                            <div class="w-summary-info">
                                <h6>Profit</h6>
                                <p class="summary-count">₹<?php echo (isset($summary['profit']))?number_format($summary['profit'],2):0; ?></p>
                            </div>

                            <div class="w-summary-stats">
                                <div class="progress">
                                    <?php $pper = (isset($summary['profit']) && isset($summary['plltotal']))?($summary['profit']/$summary['plltotal']) * 100:0; ?>
                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?php echo floor($pper); ?>%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="summary-list">
                        <div class="w-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                        <div class="w-summary-details">
                            
                            <div class="w-summary-info">
                                <h6>Expenses</h6>
                                <p class="summary-count">₹<?php echo (isset($summary['lose']))?number_format($summary['lose'],2):0; ?></p>
                            </div>

                            <div class="w-summary-stats">
                                <div class="progress">
                                    <?php $eper = (isset($summary['lose']) && isset($summary['plltotal']))?($summary['lose']/$summary['plltotal']) * 100:0; ?>
                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?php echo floor($eper); ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="summary-list">
                        <div class="w-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </div>
                        <div class="w-summary-details">
                            
                            <div class="w-summary-info">
                                <h6>Loan</h6>
                                <p class="summary-count">₹<?php echo (isset($summary['loan']))?number_format($summary['loan'],2):0; ?></p>
                            </div>

                            <div class="w-summary-stats">
                                <div class="progress">
                                    <?php $lper = (isset($summary['loan']) && isset($summary['plltotal']))?($summary['loan']/$summary['plltotal']) * 100:0; ?>
                                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo floor($lper); ?>%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                        </div>

                    </div>
                    
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
                        <span class="w-value">₹<?php echo (isset($cctotal))?number_format($cctotal, 2):0; ?></span>
                        <span class="w-numeric-title">Total CC Account Loans</span>
                    </div>
                </div>
                <div class="w-chart">
                    <div id="total-orders"></div>
                </div>
            </div>
        </div>
    </div>

</div>
