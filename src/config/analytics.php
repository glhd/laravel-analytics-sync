<?php
/**
 * Laravel Analytics Sync config file
 *
 * @package Galahad\LaravelAnalyticsSync
 */
return [
    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This is the model that should be used as User, where the column to store
    | the Google Analytics Client ID should be stored.
    |
    */
    'model' => 'App\User',
    /*
    |--------------------------------------------------------------------------
    | User table
    |--------------------------------------------------------------------------
    |
    | This is the table name where you store User models.
    |
    */
    'table' => 'users',
    /*
    |--------------------------------------------------------------------------
    | Google Analytics Client ID column name
    |--------------------------------------------------------------------------
    |
    | This is the column name on the User model, where the Google Analytics
    | Client ID is stored.
    |
    */
    'column' => 'analytics_client_id',
];