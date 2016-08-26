<?php
/**
 * Laravel Analytics Sync config file
 *
 * @package Galahad\LaravelAnalyticsSync
 */
return [
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