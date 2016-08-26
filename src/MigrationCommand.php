<?php

namespace Galahad\LaravelAnalyticsSync;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

/**
 * Class MigrationCommand
 *
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class MigrationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'analytics:migrate';


    /**
     * @var string
     */
    protected $description = 'Add a column to store the Google Analytics Client ID';

    /**
     *
     */
    public function handle()
    {
        /** @var \Illuminate\View\Factory $view */
        $view = $this->laravel->view;
        $view->addNamespace('analytics', __DIR__.'/views');
        $data = $this->getDataFromConfig();
        $migrationFile = database_path('migrations').'/'.date('Y_m_d_His').'_google_analytics_add_client_id.php';
        $migrationContent = $view->make('analytics::generators.migration')->with($data)->render();
    }

    public function getDataFromConfig()
    {
        return [
            'table' => Config::get('analytics.table'),
            'column' => Config::get('analytics.column'),
        ];
    }
}