<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\EasyLoanController;
use App\Http\Controllers\GenealogyController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VtuController;
use App\Http\Controllers\WalletController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('MainHomePage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('main_page');

// Route::get('/dashboard', function () {
//     // return Inertia::render('Dashboard');
//     return Inertia::render('HomeView');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tables', function () {
    return Inertia::render('TablesView');
})->name('tables');

Route::get('/forms', function () {
    return Inertia::render('FormsView');
})->name('forms');

Route::get('/ui', function () {
    return Inertia::render('UiView');
})->name('ui');

Route::get('/responsive', function () {
    return Inertia::render('ResponsiveView');
})->name('responsive');

Route::get('/profile', function () {
    return Inertia::render('ProfileView');
})->name('profile');

Route::get('/sign_in', function () {
    return Inertia::render('Auth/Login');
})->name('sign_in');

Route::get('/error', function () {
    return Inertia::render('ErrorView');
})->name('error');



require __DIR__.'/auth.php';

Route::post('/submit_front_page_message', [MainPageController::class, 'submitFrontPageMessage'])->name('submit_front_page_message');

Route::post('/news_letter_list', [NewsLetterController::class, 'store'])->name('news_letter_list.store');

Route::get('/test/social_media_home', [TestController::class, 'socialMediaHomePage'])->name('tests.social_media_home');



Route::middleware(['providus', 'verified', 'auth'])->group(function () {
    Route::get('/registration_step_2', [AuthenticatedSessionController::class, 'registrStep2'])->name('registration_step_2');
    Route::post('/submit_proof_of_payment_to_admin', [AuthenticatedSessionController::class, 'submitProofOfPaymentToAdmin'])->name('submit_proof_of_payment_to_admin');
    Route::post('/get_placement_info_registration', [AuthenticatedSessionController::class, 'getPlacementInfoRegistration'])->name('get_reg_placement_info');
    Route::post('/select_positioning_for_mlm_registration', [AuthenticatedSessionController::class, 'selectPositioningForMlmRegistration'])->name('select_positioning_for_mlm_registration');
    Route::post('/complete_registration_step_2', [AuthenticatedSessionController::class, 'completeRegistrationStep2'])->name('complete_registration_step_2');
});

Route::middleware(['providus', 'auth', 'verified', 'check_registration', 'admin'])->group(function () {


    Route::get('/manage_vtu_history', [AdminController::class, 'loadManageVtuPageHistory'])->name('manage_vtu_history');
    Route::get('/manage_vtu/{param1?}', [AdminController::class, 'loadManageVtuPage'])->name('manage_vtu');
    Route::get('/goeasy_savings_admin', [AdminController::class, 'loadAdminGoEasySavingsPage'])->name('goeasy_savings_admin');
    Route::get('/airtime_to_wallet_records', [AdminController::class, 'loadAirtimeToWalletRecordsPage'])->name('airtime_to_wallet_records');
    Route::get('/downline_members', [AdminController::class, 'loadDownlineMembersPage'])->name('downline_members');
    Route::get('/account_credit_requests', [AdminController::class, 'loadAccountCreditRequestsPage'])->name('account_credit_requests');
    Route::get('/account_withdrawal_requests', [AdminController::class, 'loadAccountWithdrawalRequestsPage'])->name('account_withdrawal_requests');
    Route::get('/view_members_list', [AdminController::class, 'loadMembersListPage'])->name('view_members_list');
    Route::get('/view_admin_vtu_earnings', [AdminController::class, 'loadAdminVtuEarningsPage'])->name('view_admin_vtu_earnings');
    Route::get('/view_advance_loan_history', [AdminController::class, 'loadAdvanceLoanHistoryPage'])->name('view_advance_loan_history');
    Route::get('/airtime_combo_requests', [AdminController::class, 'loadAirtimeComboRequestsPage'])->name('airtime_combo_requests');
    Route::get('/data_combo_requests', [AdminController::class, 'loadDataComboRequestsPage'])->name('data_combo_requests');
    Route::get('/account_credit_history', [AdminController::class, 'loadAccountCreditHistoryPage'])->name('account_credit_history');
    Route::get('/admin_account_credit_history', [AdminController::class, 'loadAdminAccountCreditHistoryPage'])->name('admin_account_credit_history');
    Route::get('/account_debit_history', [AdminController::class, 'loadAccountDeditHistoryPage'])->name('account_debit_history');
    Route::get('/product_advance_history', [AdminController::class, 'loadProductAdvanceHistoryPage'])->name('product_advance_history');
    Route::get('/manage_news', [AdminController::class, 'loadManageNewsPage'])->name('manage_news');
    Route::get('/manage_feedback', [AdminController::class, 'loadManageFeedbackPage'])->name('manage_feedback');
    Route::get('/manage_faq', [AdminController::class, 'loadManageFaq'])->name('manage_faq');
    Route::get('/earnings', [AdminController::class, 'loadAdminEarningsPage'])->name('admin_earnings');
    Route::get('/airtime_combo_recharge_history', [AdminController::class, 'loadAirtimeComboRechargeHistoryPage'])->name('airtime_combo_recharge_history');
    Route::get('/data_combo_recharge_history', [AdminController::class, 'loadDataComboRechargeHistoryPage'])->name('data_combo_recharge_history');
    Route::get('/admin_edit_user_profile/{user}', [AdminController::class, 'loadAdminEditUserProfilePage'])->name('admin_edit_user_profile');
    Route::get('/account_credit_history/{user}', [AdminController::class, 'loadUsersAccountCreditHistoryPage'])->name('users_account_credit_history');
    Route::get('/withdrawal_history/{user}', [AdminController::class, 'loadUsersAccountWithdrawalHistoryPage'])->name('users_withdrawal_history');
    Route::get('/users_earnings_to_wallet/{user}', [AdminController::class, 'loadUsersEarningsToWalletHistoryPage'])->name('users_earnings_to_wallet');
    Route::get('/users_easy_loan_history/{user}', [AdminController::class, 'loadUsersEasyLoanHistoryPage'])->name('users_easy_loan_history');
    Route::get('/users_earnings_wallet/{user}', [AdminController::class, 'loadUsersEarningsWalletPage'])->name('users_earnings_wallet');

    Route::get('users_goeasy_savings/{user}', [AdminController::class, 'showUsersSavingsMainPage'])->name('users_goeasy_savings_main_page');

    Route::get('users_savings_history/{user}', [AdminController::class, 'showUsersSavingsHistoryPage'])->name('users_savings_history');
    Route::get('users_savings_debit_history/{user}/{easySaving}', [AdminController::class, 'showSavingsDebitHistoryPage'])->name('users_savings_debit_history');
    Route::get('users_savings_auto_withd_history/{user}', [AdminController::class, 'showUsersSavingsAutoWithdHistoryPage'])->name('users_savings_auto_withd_history');
    Route::get('users_saving/{user}/{easySaving}', [AdminController::class, 'showUsersSavingDetailsPage'])->name('view_users_saving_details');

    Route::get('/vtu_history/{user}', [AdminController::class, 'loadUsersVtuHistoryPage'])->name('users_vtu_history');
    Route::get('/transfer_history/{user}', [AdminController::class, 'loadUsersTransferHistoryPage'])->name('users_transfer_history');
    Route::get('/admin_credit_history/{user}', [AdminController::class, 'loadUsersAdminCreditHistoryPage'])->name('users_admin_credit_history');
    Route::get('/admin_debit_history/{user}', [AdminController::class, 'loadUsersAdminDebitHistoryPage'])->name('users_admin_debit_history');
    Route::get('/account_statement/{user}', [AdminController::class, 'loadUsersAccountStatementPage'])->name('users_account_statement');



    Route::post('/save_educational_plans_settings', [AdminController::class, 'saveEducationalPlansSettings'])->name('save_educational_plans_settings');
    Route::post('/load_educational_plans_details_by_network_admin', [AdminController::class, 'loadEducationalPlanDetailsByNetwork'])->name('load_educational_plans_details_by_network_admin');
    Route::post('/save_router_plans_settings', [AdminController::class, 'saveRouterPlansSettings'])->name('save_router_plans_settings');
    Route::post('/load_router_plans_details_by_network_admin', [AdminController::class, 'loadRouterPlanDetailsByNetwork'])->name('load_router_plans_details_by_network_admin');
    Route::post('/save_cable_plans_settings', [AdminController::class, 'saveCablePlansSettings'])->name('save_cable_plans_settings');
    Route::post('/load_cable_plans_details_by_network_admin', [AdminController::class, 'loadCablePlanDetailsByNetwork'])->name('load_cable_plans_details_by_network_admin');
    Route::post('/load_all_vtu_history', [AdminController::class, 'loadAllVtuHistory'])->name('load_all_vtu_history_admin');
    Route::post('/save_electricity_plans_settings', [AdminController::class, 'saveElectricitySettings'])->name('save_electricity_plans_settings');
    Route::post('/load_electricity_details_admin', [AdminController::class, 'loadElectricityDetailsByNetwork'])->name('load_electricity_details_admin');
    Route::post('/save_airtime_plans_settings', [AdminController::class, 'saveAirtimeSettings'])->name('save_airtime_plans_settings');
    Route::post('/load_airtime_details_by_network_admin', [AdminController::class, 'loadAirtimeDetailsByNetwork'])->name('load_airtime_details_by_network_admin');
    Route::post('/save_data_plans_settings', [AdminController::class, 'saveDataPlansSettings'])->name('save_data_plans_settings');
    Route::post('/load_data_plans_details_by_network_admin', [AdminController::class, 'loadDataPlanDetailsByNetwork'])->name('load_data_plans_details_by_network_admin');
    Route::post('/mark_combo_record_as_recharged', [AdminController::class, 'markComboRecordAsRecharged'])->name('mark_combo_record_as_recharged');
    Route::post('/dismiss_account_credit_withdrawal', [AdminController::class, 'dismissAccountCreditWithdrawal'])->name('dismiss_account_credit_withdrawal');
    Route::post('/verify_account_credit_withdrawal', [AdminController::class, 'verifyAccountCreditWithdrawal'])->name('verify_account_credit_withdrawal');
    Route::post('/process_edit_users_profile/{user}', [AdminController::class, 'processEditUsersProfile'])->name('process_edit_users_profile');
    Route::post('/get_user_data/{user}', [AdminController::class, 'getUserData'])->name('get_user_data');
    Route::post('/credit_user/{user}', [AdminController::class, 'processCreditUser'])->name('credit_user');
    Route::post('/debit_user/{user}', [AdminController::class, 'processDebitUser'])->name('debit_user');
});

Route::middleware(['providus', 'auth', 'verified'])->group(function () {

    Route::get('/test_airtime', [SetupController::class, 'testAirtime']);


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/edit_profile', [ProfileController::class, 'edit'])->name('edit_profile');


    Route::get('change_password', [ChangePasswordController::class, 'edit'])->name('change_password');



    Route::get('referral_link', [DashboardController::class, 'showReferralLink'])->name('referral_link');

    Route::get('genealogy_tree', [GenealogyController::class, 'showGenealogyTree'])->name('genealogy_tree');
    Route::get('sponsor_tree', [GenealogyController::class, 'showSponsorTree'])->name('sponsor_tree');

    Route::get('recharge_vtu/airtime', [VtuController::class, 'showAirtimeTopupPage'])->name('airtime_topup');
    Route::get('recharge_vtu/data', [VtuController::class, 'showInternetDataPage'])->name('internet_data');
    Route::get('recharge_vtu/cable_tv', [VtuController::class, 'loadCableTvPage'])->name('cable_tv');
    Route::get('recharge_vtu/electricity', [VtuController::class, 'showElectricityPage'])->name('electricity_topup');
    Route::get('recharge_vtu/airtime_to_wallet', [VtuController::class, 'showAirtimeToWalletPage'])->name('airtime_to_wallet');
    Route::get('recharge_vtu/router', [VtuController::class, 'showRouterRechargePage'])->name('router_recharge');
    Route::get('recharge_vtu/educational', [VtuController::class, 'showEducationalVouchersPage'])->name('educational_vouchers');
    Route::get('/recharge_vtu/history', [VtuController::class, 'userVtuHistoryPage'])->name('user_vtu_history_page');



    Route::get('wallet/overview', [WalletController::class, 'index'])->name('wallet.overview');
    Route::get('wallet/credit', [WalletController::class, 'loadCreditUserWalletPage'])->name('wallet.credit');
    Route::get('wallet/credit_history', [WalletController::class, 'showWalletCreditHistoryPage'])->name('wallet.credit_history');
    Route::get('wallet/transfer', [WalletController::class, 'loadFundsTransferPage'])->name('wallet.transfer');
    Route::get('wallet/transfer_history', [WalletController::class, 'showTransferHistoryPage'])->name('wallet.transfer_history');
    Route::get('wallet/withdrawal', [WalletController::class, 'loadFundsWithdrawalPage'])->name('wallet.withdrawal');
    Route::get('wallet/withdrawal_history', [WalletController::class, 'showWithdrawalHistoryPage'])->name('wallet.withdrawal_history');
    Route::get('wallet/statement', [WalletController::class, 'showWalletStatementPage'])->name('wallet.statement');
    Route::get('earning_to_wallet_hist', [WalletController::class, 'showEarningToWalletPage'])->name('earning_to_wallet_hist');

    Route::get('easy_loan', [EasyLoanController::class, 'showApplicationPage'])->name('apply_for_easy_loan_page');
    Route::get('easy_loan_history', [EasyLoanController::class, 'showLoanHitsoryPage'])->name('easy_loan_history_page');


    Route::get('goeasy_savings', [SavingsController::class, 'showMainPage'])->name('goeasy_savings_main_page');
    Route::get('apply_for_savings', [SavingsController::class, 'applyForSavings'])->name('apply_for_savings');
    Route::get('savings_history', [SavingsController::class, 'showSavingsHistoryPage'])->name('savings_history');
    Route::get('savings_debit_history/{easySaving}', [SavingsController::class, 'showSavingsDebitHistoryPage'])->name('savings_debit_history');
    Route::get('savings_auto_withd_history', [SavingsController::class, 'showSavingsAutoWithdHistoryPage'])->name('savings_auto_withd_history');
    Route::get('deactivate_saving_plan', [SavingsController::class, 'showDeactivateSavingPlanPage'])->name('deactivate_saving_plan');
    Route::get('saving/{easySaving}', [SavingsController::class, 'showSavingDetailsPage'])->name('view_saving_details');
    Route::get('earnings_wallet', [EarningsController::class, 'showEarningsMainPage'])->name('earnings_wallet_page');






    Route::get('/tables', function () {
        return Inertia::render('TablesView');
    })->name('tables');

    Route::get('/forms', function () {
        return Inertia::render('FormsView');
    })->name('forms');

    Route::get('/ui', function () {
        return Inertia::render('UiView');
    })->name('ui');

    Route::get('/responsive', function () {
        return Inertia::render('ResponsiveView');
    })->name('responsive');

    Route::get('/profile', function () {
        return Inertia::render('ProfileView');
    })->name('profile');

    Route::get('/sign_in', function () {
        return Inertia::render('LoginView');
    })->name('sign_in');

    Route::get('/error', function () {
        return Inertia::render('ErrorView');
    })->name('error');



    Route::post('/wallet/statement_details', [WalletController::class, 'statementDetails'])->name('wallet.statement_details');
    Route::post('/wallet/paystack_payment_init', [WalletController::class, 'paystackPaymentInit'])->name('wallet.paystack_payment_init');
    Route::post('transfer_earnin_to_main_wallet', [EarningsController::class, 'transferEarningToMainWallet'])->name('transfer_earnin_to_main_wallet');
    Route::post('process_savings_deactivation', [SavingsController::class, 'processDeactivation'])->name('process_savings_deactivation');
    Route::post('process_apply_for_easy_savings', [SavingsController::class, 'processApplication'])->name('process_apply_for_easy_savings');
    Route::post('process_apply_for_easy_loan', [EasyLoanController::class, 'processApplication'])->name('process_apply_for_easy_loan');
    Route::post('/edit_profile', [ProfileController::class, 'update'])->name('process_edit_profile');
    Route::post('change_password', [ChangePasswordController::class, 'update'])->name('process_change_password');
    Route::post('/transfer_funds_to_user', [WalletController::class, 'processTransferFundsToUser'])->name('transfer_funds_to_user');
    Route::post('/verify_transfer_otp', [WalletController::class, 'processVerifyTransferOtp'])->name('verify_transfer_otp');
    Route::post('/withdraw_funds_cont', [WalletController::class, 'processWithdrawFundsCont'])->name('withdraw_funds_cont');
    Route::post('/enter_amount_withdraw_funds', [WalletController::class, 'processEnterAmountWithdrawFunds'])->name('enter_amount_withdraw_funds');
    Route::post('/validate_withdrawal_otp', [WalletController::class, 'processValidateWithdrawalOtp'])->name('validate_withdrawal_otp');
    Route::post('/recharge_vtu/request_9mobile_combo_recharge', [VtuController::class, 'request9mobileComboRecharge'])->name('request_9mobile_combo_recharge');
    Route::post('/recharge_vtu/normal_airtime_recharge_request', [VtuController::class, 'normalAirtimeRechargeRequest'])->name('normal_airtime_recharge_request');
    Route::post('/recharge_vtu/reloadly_recharge_request', [VtuController::class, 'reloadlyRechargeRequest'])->name('reloadly_recharge_request');
    Route::post('/recharge_vtu/generate_vtu_epin', [VtuController::class, 'generateEpin'])->name('generate_vtu_epin');
    Route::post('/recharge_vtu/get_data_plans_by_network', [VtuController::class, 'getDataPlansByNetwork'])->name('get_data_plans_by_network');
    Route::post('/recharge_vtu/purchase_9mobile_combo_data', [VtuController::class, 'purchase9mobileComboData'])->name('purchase_9mobile_combo_data');
    Route::post('/recharge_vtu/purchase_payscribe_data', [VtuController::class, 'purchasePayscribeData'])->name('purchase_payscribe_data');
    Route::post('/recharge_vtu/purchase_clubkonnect_data', [VtuController::class, 'purchaseClubKonnectData'])->name('purchase_clubkonnect_data');
    Route::post('/recharge_vtu/purchase_gsubz_data', [VtuController::class, 'purchaseGsubzData'])->name('purchase_gsubz_data');
    Route::post('/recharge_vtu/purchase_eminence_data', [VtuController::class, 'purchaseEminenceData'])->name('purchase_eminence_data');
    Route::post('/recharge_vtu/check_if_disco_is_available', [VtuController::class, 'checkIfDiscoIsAvailable'])->name('check_if_disco_is_available');
    Route::post('/recharge_vtu/validate_meter_number_disco', [VtuController::class, 'validateMeterNumberDisco'])->name('validate_meter_number_disco');
    Route::post('/recharge_vtu/purchase_electricity_with_payscribe', [VtuController::class, 'purchaseElectricityWithPayscribe'])->name('purchase_electricity_with_payscribe');
    Route::post('/recharge_vtu/purchase_electricity_with_buypower', [VtuController::class, 'purchaseElectricityWithBuypower'])->name('purchase_electricity_with_buypower');
    Route::post('/recharge_vtu/validate_decoder_number_cable_plans', [VtuController::class, 'validateDecoderNumberCablePlans'])->name('validate_decoder_number_cable_plans');
    Route::post('/recharge_vtu/purchase_cable_tv_plan', [VtuController::class, 'purchaseCableTvPlan'])->name('purchase_cable_tv_plan');
    Route::post('/recharge_vtu/get_charge_for_airtime_to_wallet_transfer', [VtuController::class, 'getChargeForAirtimeToWalletTransfer'])->name('get_charge_for_airtime_to_wallet_transfer');
    Route::post('/recharge_vtu/validate_airtime_to_wallet_details', [VtuController::class, 'validateAirtimeToWalletDetails'])->name('validate_airtime_to_wallet_details');
    Route::post('/recharge_vtu/process_airtime_to_wallet_transfer', [VtuController::class, 'processAirtimeToWalletTransfer'])->name('process_airtime_to_wallet_transfer');
    Route::post('/recharge_vtu/load_router_bundles_and_verify_number', [VtuController::class, 'loadRouterBundlesAndVerifyNumber'])->name('load_router_bundles_and_verify_number');
    Route::post('/recharge_vtu/recharge_router', [VtuController::class, 'rechargeRouter'])->name('recharge_router');
    Route::post('/track_club_vtu_order', [VtuController::class, 'trackClubVtuOrder'])->name('track_club_vtu_order');
    Route::post('/track_eminence_vtu_order', [VtuController::class, 'trackEminenceVtuOrder'])->name('track_eminence_vtu_order');
    Route::post('/track_reloadly_vtu_order', [VtuController::class, 'trackReloadlyVtuOrder'])->name('track_reloadly_vtu_order');
    Route::post('/track_payscribe_vtu_order_data', [VtuController::class, 'trackPayscribeVtuOrderData'])->name('track_payscribe_vtu_order_data');
    Route::post('/track_payscribe_vtu_epin', [VtuController::class, 'trackPayscribeVtuEpin'])->name('track_payscribe_vtu_epin');
    Route::post('/track_payscribe_educational_epin', [VtuController::class, 'trackPayscribeEducationalEpin'])->name('track_payscribe_educational_epin');
    Route::post('/recharge_vtu/buy_eminence_educational_voucher_vtu', [VtuController::class, 'buyEminenceEducationalVoucherVtu'])->name('buy_eminence_educational_voucher_vtu');
    Route::post('/recharge_vtu/buy_educational_voucher_vtu', [VtuController::class, 'buyEducationalVoucherVtu'])->name('buy_educational_voucher_vtu');


    Route::post('/view_your_genealogy_tree_down', [GenealogyController::class, 'viewYourGenealogyTreeDown'])->name('view_your_genealogy_tree_down');
    Route::post('/view_your_genealogy_tree', [GenealogyController::class, 'viewYourGenealogyTree'])->name('view_your_genealogy_tree');
    Route::post('/search_users_genealogy_tree', [GenealogyController::class, 'searchUsersGenealogy'])->name('search_users_genealogy_tree');
});
