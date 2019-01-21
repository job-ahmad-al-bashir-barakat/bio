<?php

namespace Aut\Autocomplete\Commands;

use Illuminate\Console\Command;

class makeAutocompleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autocomplete:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish all content autocompelte';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $files = [
        //---------------------------------------config--------------------------------------//
        'config/autocompleteModels.stub'               => 'config/autocompleteModels.php',
        'helper/AutocompleteHelper.stub'               => 'app/Library/AutocompleteHelper.php',
    ];

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        // Dir Files
        if (! is_dir(base_path('app/Library'))) {
            mkdir(base_path('app/Library'), 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportFiles()
    {
        $this->loopFiles($this->files);
    }

    protected function loopFiles($files)
    {
        foreach ($files as $key => $value)
        {
            $path = base_path($value);

            $this->line('<info>Created File:</info> '.$path);

            copy(__DIR__.'/stubs/make/'.$key, $path);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportFiles();

        $this->comment('Autocompelte scaffolding generated successfully!');
    }
}
