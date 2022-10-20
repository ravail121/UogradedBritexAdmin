<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  function () {
    return view('auth.login');
})->middleware('guest');

Route::group(['middleware' => ['auth', 'auth.master.staff'] ], function () {

	Route::get('/dashboard',  function () {
	    return view('dashboard');
	});

	Route::get('/search-customer', 'SearchController@index')->name('search.customer');

	Route::post('/change-business-status', 'BusinessVerificationController@changeBusinessStatus')->name('change.status');

	Route::get('/zip/{id}', 'BusinessVerificationController@downloadZip')->name('zip');

	Route::get('/download/{path}', 'BusinessVerificationController@downloadFile')->name('download.doc');

	Route::post('/reject', 'BusinessVerificationController@rejectBusiness')->name('reject.business');

	Route::get('/biz-verification', 'BusinessVerificationController@index')->name('businessVerification');

	Route::get('/email-template', 'EmailTemplateController@index')->name('emailTemplate');

	Route::get('/canned-response', 'EmailTemplateController@cannedResponse')->name('cannedResponse');

	Route::get('/email-template/datatables', 'EmailTemplateController@getAllTemplate')->name('email.template.datatable');

	Route::get('/canned-response/datatables', 'EmailTemplateController@getCannedResponseData')->name('cannded.response.datatable');

	Route::post('/edit-email-template', 'EmailTemplateController@edit')->name('edit.email.template');

	Route::post('/add-email-template', 'EmailTemplateController@add')->name('add.email.template');

	Route::post('/edit-canned-response', 'EmailTemplateController@editCannedResponse')->name('edit.canned.response');

	Route::post('/add-canned-response', 'EmailTemplateController@addCannedData')->name('add.canned.response');

	Route::post('/delete-email-template', 'EmailTemplateController@deleteEmailTemplate')->name('delete.email.template');

	Route::post('/delete-canned-response', 'EmailTemplateController@deleteCanndedResponse')->name('delete.canned.response');

	Route::get('/coupon', 'CouponController@index')->name('coupon.index');

	Route::post('/edit-coupon', 'CouponController@edit')->name('edit.coupon');

	Route::post('/add-coupon', 'CouponController@add')->name('add.coupon');

	Route::post('/check-coupon', 'CouponController@checkCoupon')->name('check.coupon');

	Route::get('/all-plans-to-addon', 'CouponController@allPlanToAddon')->name('plans-to-addon');

	Route::get('/all-device-to-addon', 'CouponController@allDeviceToAddon')->name('device-to-addon');
	
	Route::get('/all-addon-to-addon', 'CouponController@allAddonToAddon')->name('addon-to-addon');

	Route::get('/all-sim-to-addon', 'CouponController@allSimToAddon')->name('sim-to-addon');

	Route::get('/CouponMultilinePlanType-to-addon', 'CouponController@allCouponMultilinePlanType')->name('multiline-to-addon');

	Route::post('/delete-coupon', 'CouponController@delete')->name('delete.coupon');	
	Route::get('/all-plans', 'PlanController@index')->name('all.plan');

	Route::post('/edit-plans', 'PlanController@edit')->name('edit.plan');

	Route::post('/add-plans', 'PlanController@add')->name('add.plan');

	Route::post('/upload-plans-image', 'PlanController@uploadImage')->name('upload.plan.image');

	Route::get('/all-plan-to-addon', 'PlanController@allPlanToAddon')->name('plan-to-addon');

	Route::get('/plan-block', 'PlanController@allCarrier')->name('plan.block');

	Route::post('/delete-plans', 'PlanController@delete')->name('delete.plan');

	Route::get('/all-devices', 'DeviceController@index')->name('all.devices');

	Route::post('/upload-description-detail-image', 'DeviceController@descriptionDetailImage')->name('description.detail.image');
	
	Route::get('/all-additional-carrier', 'DeviceController@allAdditionalCarrier')->name('additional-carrier');

	Route::get('/all-device-to-plan', 'DeviceController@allDeviceToPlan')->name('device-to-plan');

	Route::get('/all-device-to-sim', 'DeviceController@allDeviceToSim')->name('device-to-sim');

	Route::post('/edit-devices', 'DeviceController@edit')->name('edit.device');

	Route::post('/add-devices', 'DeviceController@add')->name('add.device');

	Route::post('/upload-devices', 'DeviceController@uploadProductImage')->name('upload.multiple.image');

	Route::post('/upload-image', 'DeviceController@uploadImage')->name('upload.device.image');

	Route::post('/delete-device', 'DeviceController@deleteDevice')->name('delete.device');

	Route::post('/delete-image', 'DeviceController@deleteImage')->name('delete.image');
	
	Route::get('/all-sims', 'SimController@index')->name('all.sims');

	Route::post('/edit-sim', 'SimController@edit')->name('edit.sim');

	Route::post('/create-sim', 'SimController@create')->name('create.sim');

	Route::post('/upload-sim-image', 'SimController@uploadImage')->name('upload.sim.image');

	Route::post('/delete-sim', 'SimController@delete')->name('delete.sim');

	Route::get('/all-addons', 'AddonController@index')->name('all.addons');
	
	Route::post('/edit-addon', 'AddonController@edit')->name('edit.addon');

	Route::post('/create-addon', 'AddonController@create')->name('create.addon');

	Route::post('/delete-addon', 'AddonController@delete')->name('delete.addon');

	Route::get('/action-queue',  function () {
	    return view('action-queue.index');
	});

	Route::get('/support',  'Support\SupportController@index')->name('support.index');

	Route::post('/support',  'Support\SupportController@store')->name('support.store');

	Route::get('support/{category}', 'Support\SupportController@show')->name('support.show');

	Route::post('support-update', 'Support\SupportController@update')->name('support.update');

	Route::post('category-update', 'Support\SupportController@updateCategory')->name('category.update');

	Route::post('category-create', 'Support\SupportController@createCategory')->name('category.create');

	Route::post('category-delete', 'Support\SupportController@destroyCategory')->name('category.delete');

	Route::post('support-delete', 'Support\SupportController@destroy')->name('support.delete');

	Route::get('/action-queue', 'ActionQueueController@index')->name('action.queue.get');

	Route::post('/action-queue', 'ActionQueueController@index')->name('action.queue');

	Route::post('/update-compleate', 'ActionQueue\UpgradeDowngradeController@updateComplete')->name('update.complete');

	Route::post('/update-addon-compleate', 'ActionQueue\UpgradeDowngradeController@updateAddonComplete')->name('update.addon.complete');

	Route::post('/reactivation-compleate', 'ActionQueue\ReactivationController@updateReactivation')->name('reactivation.complete');

	Route::post('/mark-shipped', 'ActionQueue\ShippingController@markShipped')->name('mark.shipped');

	Route::post('/mark-active', 'ActionQueue\ActiveController@markActive')->name('mark.active');

	Route::post('/update-closed', 'ActionQueue\ClosedController@updateClosed')->name('update.closed');

	Route::post('/reopen-closed-subscription', 'ActionQueue\ClosedController@reopenClosedSubscription')->name('reopen.closed');

	Route::post('/update-processed', 'ActionQueue\ShippingController@updateProcessed')->name('update.processed');

	Route::post('/update-account-suspended', 'ActionQueue\SuspendedController@updateAccountSuspended')->name('update.account.suspended');

	Route::post('/update-unsuspend', 'ActionQueue\SuspendedController@updateUnsuspend')->name('update.unsuspend');

	Route::post('/update-suspended-close', 'ActionQueue\SuspendedController@updateSuspendedClose')->name('update.suspended.close');

	Route::post('/update-suspendedB', 'ActionQueue\SuspendedController@updateSuspendedB')->name('update.SuspendedB');

	Route::post('/set-active', 'ActionQueue\ActivationController@setActive')->name('subscription.activation');

	Route::post('/validate-subscription-phone-number', 'ActionQueue\ActivationController@validatePhoneNumber')->name('subscription.check-phone-uniqueness');

	Route::post('/confirm-port', 'ActionQueue\PortingController@setComplete')->name('port.complete');

	Route::post('/reject-port', 'ActionQueue\PortingController@rejectPort')->name('port.reject');

	Route::post('/response-port', 'ActionQueue\PortingController@getResponsePort')->name('get.response.data');

	Route::post('/get-bangroup', 'ActionQueue\ActivationController@getBanGroup')->name('ban.group');

	Route::get('actionQueue/datatables', 'ActionQueue\ShippingController@getShippingData')->name('actionQueue.datatables');

	Route::get('upgrade-downgrade/datatables', 'ActionQueue\UpgradeDowngradeController@getUpgradeDowngradeData')->name('actionQueue.upgrade.datatables');

	Route::get('addon/datatables', 'ActionQueue\UpgradeDowngradeController@getAddonData')->name('actionQueue.addon.datatables');

	Route::get('activation/datatables', 'ActionQueue\ActivationController@getActivationData')->name('actionQueue.activation.datatables');

	Route::get('cloud-activation/datatables', 'ActionQueue\ActivationController@getCloudActivationData')->name('actionQueue.cloudactivation.datatables');

	Route::get('active/datatables', 'ActionQueue\ActiveController@getActiveData')->name('actionQueue.active.datatables');

	Route::get('past-due/datatables', 'ActionQueue\PastDueController@getPastDue')->name('actionQueue.pastdue.datatables');

	Route::get('reactivation/datatables', 'ActionQueue\ReactivationController@getReactivationData')->name('actionQueue.reactivation.datatables');

	Route::get('porting/datatables', 'ActionQueue\PortingController@getPortData')->name('actionQueue.porting.datatables');

	Route::get('close-a/datatables', 'ActionQueue\ClosedController@getCloseAData')->name('actionQueue.closeA.datatables');

	Route::get('close-b/datatables', 'ActionQueue\ClosedController@getCloseBData')->name('actionQueue.closeB.datatables');

	Route::get('suspended-a/datatables', 'ActionQueue\SuspendedController@getSuspendedAData')->name('actionQueue.suspendedA.datatables');

	Route::get('suspended-b/datatables', 'ActionQueue\SuspendedController@getSuspendedBData')->name('actionQueue.suspendedB.datatables');

	Route::get('/iframe-image', 'BusinessVerificationController@getImage')->name('iframe.image');
	
	// Route::get('/customers', 'CustomerController@index')->name('customers.list');

	Route::get('customers/{customer}', 'CustomerController@show')->name('customers.detail');

	Route::get('customer/datatables', 'CustomerController@getSubscriptionData');

	Route::get('customer/log/datatables/{customer}', 'CustomerController@getAllLog')->name('customer.log.datatable');

	Route::post('/add-email-log', 'CustomerController@addEmailLog')->name('add.email.log');

	Route::get('email-history/datatables/{customer}', 'CustomerController@getAllEmailLog')->name('email.log.datatable');

	Route::get('subscription/datatables{customer_id?}', 'Customer\SubscriptionController@getSubscriptionData')->name('customer.subscription.datatables');

	Route::get('billing-history/datatables{customer_id?}', 'Customer\BillingController@getBillingHistoryData')->name('customer.billing.history.datatables');

	Route::post('add-card{customer_id?}', 'Customer\BillingController@addCard')->name('add.card');

	Route::get('payment-logs/datatables{customer_id?}', 'Customer\BillingController@getPaymentLogData')->name('customer.payment.log.datatables');

	Route::get('all-coupons/datatables', 'CouponController@getAllCoupons')->name('allcoupon.datatable');

	Route::post('coupon/get', 'CouponController@getCoupons')->name('get.coupon');

	Route::post('coupon/add', 'CouponController@applyCoupon')->name('apply.coupon');

	Route::post('coupon/delete', 'CouponController@deleteCoupon')->name('delete.user-coupon');

	Route::get('all-plans/datatables', 'PlanController@getAllPlans')->name('allplan.datatable');

	Route::get('all-devices/datatables', 'DeviceController@getAllDevices')->name('alldevice.datatable');

	Route::get('all-sims/datatables', 'SimController@getAllSims')->name('allsim.datatable');
	
	Route::get('all-addons/datatables', 'AddonController@getAllAddons')->name('alladdon.datatable');

	Route::post('/update-customer', 'CustomerController@updateCustomer')->name('update.customer');

	Route::post('/check-number', 'Customer\SubscriptionController@checkNumber')->name('check.number');

	Route::post('/update-subcription', 'Customer\SubscriptionController@updateSubcription')->name('update.subcription');

	Route::post('/check-email{customer_id}', 'CustomerController@checkEmail')->name('check.email');

	Route::post('/update-autopay{customer_id}', 'Customer\BillingController@updateAutoPay')->name('update.autopay');

	Route::post('/add-note{customer_id}', 'CustomerController@addNote')->name('add.customer.note');

	Route::post('/manual-payment{customer_id}', 'Customer\BillingController@manualPayment')->name('manual.payment');

	Route::post('/manual-credit{customer_id}', 'Customer\BillingController@manualCredit')->name('manual.credit');

	Route::post('/custom-invoice{customer_id}', 'Customer\BillingController@customInvoice')->name('custom.invoice');

	Route::post('/process-refund', 'Customer\BillingController@processRefund')->name('process.refund');

	Route::post('/update-shippinginfo/{customer_id}', 'Customer\BillingController@updateCustomerShippingInfo')->name('update.shipping.info');

	Route::post('/update-billinginfo/{customer_id}', 'Customer\BillingController@updateCustomerBillingInfo')->name('update.billing.info');

	Route::post('update-port', 'ActionQueue\PortingController@updatePort')->name('update.port');

	Route::post('update-port-status', 'ActionQueue\PortingController@updatePortStatus')->name('update.port.status');

//	Route::get('/tbc-report', 'Report\TBCReportController@index')->name('tbc.report');
	
	Route::get('/cron-tester', 'CronTester\CronTesterController@index')->name('cron.index');

	Route::get('/cron-tester/get-logs', 'CronTester\CronTesterController@getLogs')->name('cron.get-logs');

	Route::get('/cron-tester/get-date', 'CronTester\CronTesterController@getDate')->name('cron.get-date');

	Route::get('/cron-tester/set-date', 'CronTester\CronTesterController@setDate')->name('cron.set-date');

	Route::get('/cron-tester/reset-date', 'CronTester\CronTesterController@resetDate')->name('cron.reset-date');

	Route::get('/cron-tester/restart-server', 'CronTester\CronTesterController@restartApache')->name('cron.restart-server');

	Route::get('/cron-tester/restart-php', 'CronTester\CronTesterController@restartPhp')->name('cron.restart-php');

	Route::get('/cron-tester/clean-cache', 'CronTester\CronTesterController@cleanCache')->name('cron.clean-cache');

	Route::get('/cron-tester/current-date', 'CronTester\CronTesterController@isCurrentServerTimeCorrect')->name('cron.current-date');

	Route::get('/ban', 'Ban\BanController@index')->name('ban.list');

	Route::get('allban/datatables', 'Ban\BanController@show')->name('allban.datatable');

	Route::get('ban-details/{ban?}', 'Ban\BanController@banDetailsDatatable')->name('ban.detail.datatable');

	Route::get('ban-subcription/{ban?}', 'Ban\BanController@banSubcriptionDatatable')->name('ban.subcription.datatable');

	Route::post('check-carrier/{companyId}', 'Ban\BanController@checkCarrier')->name('check.carrier');

	Route::post('all-node', 'Ban\BanController@allNode')->name('all.node');

	Route::post('all-fan', 'Ban\BanController@allfan')->name('all.fan');

	Route::post('insert-node', 'Ban\BanController@insertNode')->name('create.node');

	Route::post('insert-fan', 'Ban\BanController@insertFan')->name('create.fan');

	Route::post('create-ban', 'Ban\BanController@create')->name('create.ban');

	Route::get('ban-detail/{ban?}', 'Ban\BanController@banDetail')->name('ban.detail');

	Route::get('ban-group-detail/{banGroup?}', 'Ban\BanController@banGroupDetail')->name('ban.groups.detail');

	Route::get('bangroup/subcription/{bangroup}', 'Ban\BanController@banGroupsubcription')->name('bangroup.subcription.datatable');

	Route::post('edit-ban', 'Ban\BanController@editBan')->name('edit.ban');

	Route::post('edit-ban-group', 'Ban\BanController@editBanGroup')->name('edit.ban.group');

	Route::post('create-ban-group', 'Ban\BanController@createBanGroup')->name('add.ban.group');

	Route::get('/staff', 'StaffController@index')->name('staff.list');

	Route::get('allstaff/datatables', 'StaffController@show')->name('allstaff.datatable');

	Route::post('create-update-stuff', 'StaffController@createUpdateStuff')->name('create.update.stuff');

	Route::post('delete-stuff', 'StaffController@delete')->name('delete.stuff');

	Route::get('/cron-tester/delete-userdata', 'CronTester\CronTesterController@clearUserData')->name('cron.clear-userdata');

	Route::get('/cron-tester/prepare-delete', 'CronTester\CronTesterController@prepareDelete')->name('cron.prepare-delete');

	Route::get('/go-know-api', 'GoKnowController@index')->name('goknow.index')->middleware('auth.goknow.key');

	Route::post('get-go-know-response', 'GoKnowController@getResponse')->name('get.goknow.response');

	Route::post('get-goknow-restore', 'GoKnowController@getRestoreResponse')->name('get.goknow.restore.response');

	Route::post('goknow-change-sim', 'GoKnowController@changeSim')->name('goknow.change.sim');

	Route::post('goknow-change-areacode', 'GoKnowController@changeAreaCode')->name('goknow.change.areacode');

	Route::post('goknow-change-areacode-csv', 'GoKnowController@uploadCsv')->name('goknow.change.areacode.csv');

	Route::post('goknow-csv-report', 'GoKnowController@csvReport')->name('goknow.csv.report');

	// tools routes
	Route::get('/tools-due-check', 'ToolsController@dueCheck')->name('dueCheck');

	Route::get('/report-check', 'ToolsController@report')->name('report');

	Route::post('check-email', 'StaffController@checkEmail')->name('check.staff.email');

	Route::post('/set-bulk-active', 'ActionQueue\ActivationController@setBulkActive')->name('subscription.bulk-activation');

	Route::post('/change-bulk-number', 'ActionQueue\ActiveController@changeBulkNumbers')->name('subscription.bulk-number-change');

	Route::get('/cron-logs', 'ToolsController@getCronLogsIndex')->name('cron-logs');

	Route::any('/get-cron-logs', 'ToolsController@getCronLogs')->name('cron.get-cron-logs');

	Route::get('/all-replacement-products', 'ReplacementProductController@index')->name('all-replacement-products');

	Route::get('all-replacement-products/datatables', 'ReplacementProductController@getAllReplacementProducts')->name('all-replacement-products.datatable');

	Route::post('/delete-replacement-products', 'ReplacementProductController@deleteReplacementProduct')->name('delete-replacement-product');

	Route::post('/edit-replacement-product', 'ReplacementProductController@edit')->name('edit-replacement-product');

	Route::post('/add-replacement-product', 'ReplacementProductController@add')->name('add-replacement-product');

	Route::post('/order-replacement-product', 'OrderController@orderReplacementProduct')->name('order-replacement-product');

	Route::post('/subscription-logs-datatables', 'SubscriptionLogController@getAllSubscriptionLogs')->name('subscription-logs.datatable');

	Route::post('/subscription-remove-requested-zip', 'ActionQueue\ActivationController@removeRequestedZip')->name('subscription.remove-requested-zip');

});

//MasterAdmin Route starts
Route::group(['middleware' => ['auth', 'auth.master.admin'] ],function () {
	Route::get('create-company', 'CompanyController@index')->name('reseller.form');

	Route::post('create-company', 'CompanyController@create')->name('create.company');

	Route::post('check-usaepay-key', 'CompanyController@checkUsaepayKey')->name('check.usaepay_api_key');

	Route::get('edit-company/{companyId}', 'CompanyController@edit')->name('edit.company');

	Route::post('update-company/{company}', 'CompanyController@update')->name('update.company');

	Route::get('all-carrier', 'CompanyController@allCarrier')->name('all.carrier');

	Route::get('master-admin', 'MasterAdminController@index')->name('master.admin');

	Route::post('change-company', 'MasterAdminController@changeCompany')->name('change.company');

	Route::get('master-logout', 'MasterAdminController@logout')->name('master-staff-logout');

	Route::get('master-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

	/**
	 * Update the billing name for all the customers
	 */
	Route::get('billing-name', 'CustomerController@billingName');

	Route::post('check-staff-email', 'StaffController@checkEmail')->name('check.master.staff.email');

});

//MasterAdmin Route EndS

Auth::routes();

/**
 * @internal Unnecessary routes commented
Route::any('phpmyadmin', '\Miroc\LaravelAdminer\AdminerController@index');

Route::get('/git-pull', 'CronTester\CronTesterController@gitPull')->name('git.pull');
 */
