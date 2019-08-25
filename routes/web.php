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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware("verified");
Route::resource("client","ClientController")->middleware(["haveAccess:client","verified"]);
Route::resource("branch","BranchController")->middleware(["haveAccess:branch","verified"]);

Route::resource("/employee","EmployeeController")->middleware(["haveAccess:employee","verified"]);


Route::get('__sbbranch', 'BranchController@__getSubBranch')->name('__sbbranch');
Route::get('getSub_subBranch', 'BranchController@getSub_subBranch')->name('getSub_subBranch');
Route::get('sbbranch', 'BranchController@getSubBranch')->name('sbbranch');
Route::get('default_branch', 'BranchController@selected_branch')->name('default_branch');



Route::get('verktyg', 'operant\OperantMasterController@verktyg');
Route::get('get-home-stage', 'operant\OperantMasterController@verktyg_home_stage');

Route::get('verktyg-step1', 'operant\OperantMasterController@verktygStep1');
Route::get('verktyg-step1-save', 'operant\OperantMasterController@verktygStep1Saving');
Route::get('verktyg-step1-edit', 'operant\OperantMasterController@verktygStep1Editing');
Route::get('add_row_stage1', 'operant\OperantMasterController@addRowFirstStage');
Route::get('verktyg-step2-edit', 'operant\OperantMasterController@PvFilteringPrilly');
Route::get('save-pv-reason', 'operant\OperantMasterController@SavePvReason');

Route::get('verktyg-step2', 'operant\OperantMasterController@verktygStep2');
Route::get('verktyg-step3', 'operant\OperantMasterController@verktygStep3');
Route::get('verktyg-step3-edit', 'operant\OperantMasterController@verktygStep3Edit');
Route::get('verktyg-step3-edit-category', 'operant\OperantMasterController@verktygStep3EditCategory');

Route::get('verktyg-step4', 'operant\OperantMasterController@verktygStep4');
Route::get('verktyg-step4-change-day', 'operant\OperantMasterController@ChangeDay');
Route::get('store-day-baseline', 'operant\OperantMasterController@StoreDayBaseLine');
Route::get('store-day-baseline-freetext', 'operant\OperantMasterController@StoreDayBaseLineFreeText');
Route::get('store-day-baseline-date', 'operant\OperantMasterController@StoreDayBaseLineDate');
Route::get('change-vecca', 'operant\OperantMasterController@ChangeVecca');
Route::get('add-vecca', 'operant\OperantMasterController@AddVecca');

Route::get('verktyg-step4-chart', 'operant\OperantController@verktygStep4Chart');
Route::get('verktyg-step5', 'operant\OperantMasterController@verktygStep5');
Route::get('store-operant-comment', 'operant\OperantMasterController@StoreOperantComment');
Route::get('get-operant-comment', 'operant\OperantMasterController@GetOperantComment');
Route::get('overskottsbeteende_store', 'operant\OperantMasterController@OverskottsbeteendeStore');

Route::get('verktyg-step5-chart', 'operant\OperantMasterController@verktygStep5Chart');
Route::get('underkottsbeteende_store', 'operant\OperantMasterController@UnderkottsbeteendeStore');

Route::get('verktyg-step6', 'operant\OperantMasterController@verktygStep6');
Route::get('add_row_stage6', 'operant\OperantMasterController@adRrowStage6');
Route::get('verktyg-step6-ov-store', 'operant\OperantMasterController@verktygStep6Saving');
Route::get('verktyg-step6-ov-edit', 'operant\OperantMasterController@verktygStep6Editing');

Route::get('verktyg-step7', 'operant\OperantMasterController@verktygStep7');
Route::get('verktyg-step7-store', 'operant\OperantMasterController@verktygStep7Store');
Route::get('verktyg-step8', 'operant\OperantMasterController@verktygStep8');
Route::get('verktyg-step8-store', 'operant\OperantMasterController@verktygStep8Store');

Route::get('kardex', 'operant\OperantController@kardex');
Route::get('hantering', 'operant\OperantController@hantering');
Route::get('operant-hantering', 'operant\OperantController@operantHantering');
Route::any('get-hantering', 'operant\OperantController@GetHanteringField');
Route::any('get-operant-hantering', 'operant\OperantController@GetOperantHanteringField');
Route::get('store-hantering', 'operant\OperantController@StoreHantering');
Route::get('change-hantering-status', 'operant\OperantController@ChangeOperantStatus');
Route::get('change-hantering-status-all', 'operant\OperantController@ChangeOperantStatusAll');
Route::get('add-new-field', 'operant\OperantController@AddNewCategoryField');
Route::get('store-client-wise-category', 'operant\OperantController@StoreClientWiseCategry');
Route::get('edit-client-wise-category', 'operant\OperantController@EditClientWiseCategry');

Route::get('observation', 'Observation\ObservationController@index');
Route::get('get-observation-home', 'Observation\ObservationController@observationHomeStage');
Route::get('save-observation-stag1', 'Observation\ObservationController@SaveObservationStag1');
Route::get('save-observation-stag1radio', 'Observation\ObservationController@SaveObservationStag1radio');
Route::get('observation-step1', 'Observation\ObservationController@observationStep1');

Route::get('observation-step2', 'Observation\ObservationController@observationStep2');

Route::get('observation-step3', 'Observation\ObservationController@observationStep3');
Route::get('store-observation-stag3', 'Observation\ObservationController@StoreobservationStep3');
Route::get('observation_stag_3_archive_store', 'Observation\ObservationController@observation_stag_3_archive_store');
Route::post('observation_archive_show', 'Observation\ObservationController@observation_archive_show');


Route::get('observation-step4', 'Observation\ObservationController@observationStep4');
Route::get('store-observation-stag4', 'Observation\ObservationController@StoreobservationStep4');

Route::get('observation-step5', 'Observation\ObservationController@observationStep5');
Route::get('store-observation-stag5', 'Observation\ObservationController@StoreobservationStep5');

Route::get('observation-step6', 'Observation\ObservationController@observationStep6');
Route::get('store-observation-stag6', 'Observation\ObservationController@StoreobservationStep6');

Route::get('observation-step7', 'Observation\ObservationController@observationStep7');
Route::get('store-observation-stag7', 'Observation\ObservationController@StoreobservationStep7');

Route::get('observation-step8', 'Observation\ObservationController@observationStep8');
Route::get('store-observation-stag8', 'Observation\ObservationController@StoreobservationStep8');

Route::get('observation-step9', 'Observation\ObservationController@observationStep9');
Route::get('store-observation-stag9', 'Observation\ObservationController@StoreobservationStep9');

Route::get('observation-step10', 'Observation\ObservationController@observationStep10');
Route::get('store-observation-stag10', 'Observation\ObservationController@StoreobservationStep10');
Route::get('observation-step11', 'Observation\ObservationController@observationStep11');
Route::get('store-observation-stag11', 'Observation\ObservationController@StoreobservationStep11');

Route::get('observation-step12', 'Observation\ObservationController@observationStep12');
Route::get('store-observation-stag12', 'Observation\ObservationController@StoreobservationStep12');

Route::get('observation-step13', 'Observation\ObservationController@observationStep13');
Route::get('add_row_stage13', 'Observation\ObservationController@addRowStage13');
Route::get('store-observation-stag13', 'Observation\ObservationController@StoreobservationStep13');
Route::get('observation_stage_13_store', 'Observation\ObservationController@observation_stage_13_store');

Route::get('observation_stag_13_archive_store', 'Observation\ObservationController@observation_stag_13_archive_store');
Route::post('observation_stag_13_archive_show', 'Observation\ObservationController@observation_stag_13_archive_show');

Route::get('store-observation-comment', 'Observation\ObservationController@StoreobservationComment');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
