<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

/**
 * Routes
 */
Route::group(['prefix' => Config::get('administrator::administrator.uri'), 'before' => 'validate_admin'], function()
{
	//Admin Dashboard
	Route::get('/', [
		'as' => 'admin_dashboard',
		'uses' => 'Frozennode\Administrator\Controllers\Admin@dashboard',
	]);

	//File Downloads
	Route::get('file_download', [
		'as' => 'admin_file_download',
		'uses' => 'Frozennode\Administrator\Controllers\Admin@fileDownload'
	]);

	//Custom Pages
	Route::get('page/{page}', [
		'as' => 'admin_page',
		'uses' => 'Frozennode\Administrator\Controllers\Admin@page'
	]);

	//The route group for all other requests needs to validate admin, model, and add assets
	Route::group(['before' => 'validate_model|post_validate'], function()
	{
		//Model Index
		Route::get('{model}', [
			'as' => 'admin_index',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@index'
		]);

		//Get Item
		Route::get('{model}/{id}', [
			'as' => 'admin_get_item',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@item'
		]);

		//New Item
		Route::get('{model}/new', [
			'as' => 'admin_new_item',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@item'
		]);

		//Update a relationship's items with constraints
		Route::post('{model}/update_options', [
			'as' => 'admin_update_options',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@updateOptions'
		]);

		//Display an image or file field's image or file
		Route::get('{model}/file', [
			'as' => 'admin_display_file',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@displayFile'
		]);

		//File Uploads
		Route::post('{model}/{field}/file_upload', [
			'as' => 'admin_file_upload',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@fileUpload'
		]);

		//Updating Rows Per Page
		Route::post('{model}/rows_per_page', [
			'as' => 'admin_rows_per_page',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@rowsPerPage'
		]);

		//CSRF protection in forms
		Route::group(['before' => 'csrf'], function()
		{
			//Save Item
			Route::post('{model}/{id?}/save', [
				'as' => 'admin_save_item',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@save'
			]);

			//Delete Item
			Route::post('{model}/{id}/delete', [
				'as' => 'admin_delete_item',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@delete'
			]);

			//Get results
			Route::post('{model}/results', [
				'as' => 'admin_get_results',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@results'
			]);

			//Custom Model Action
			Route::post('{model}/custom_action', [
				'as' => 'admin_custom_model_action',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@customModelAction'
			]);

			//Custom Item Action
			Route::post('{model}/{id}/custom_action', [
				'as' => 'admin_custom_model_item_action',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@customModelItemAction'
			]);
		});
	});


	Route::group(['before' => 'validate_settings|post_validate'], function()
	{
		//Settings Pages
		Route::get('settings/{settings}', [
			'as' => 'admin_settings',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@settings'
		]);

		//Settings file upload
		Route::post('settings/{settings}/{field}/file_upload', [
			'as' => 'admin_settings_file_upload',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@fileUpload'
		]);

		//Display a settings file
		Route::get('settings/{settings}/file', [
			'as' => 'admin_settings_display_file',
			'uses' => 'Frozennode\Administrator\Controllers\Admin@displayFile'
		]);

		//CSRF routes
		Route::group(['before' => 'csrf'], function()
		{
			//Save Item
			Route::post('settings/{settings}/save', [
				'as' => 'admin_settings_save',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@settingsSave'
			]);

			//Custom Action
			Route::post('settings/{settings}/custom_action', [
				'as' => 'admin_settings_custom_action',
				'uses' => 'Frozennode\Administrator\Controllers\Admin@settingsCustomAction'
			]);
		});
	});

	//Switch locales
	Route::get('switch_locale/{locale}', [
		'as' => 'admin_switch_locale',
		'uses' => 'Frozennode\Administrator\Controllers\Admin@switchLocale'
	]);
});