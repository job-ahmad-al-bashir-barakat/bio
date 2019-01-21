<?php

namespace Aut\DataTable\Commands;

use Illuminate\Console\Command;

class MakeDataTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datatable:publish 
        {module? : The moudle of modules will be create datatable on it.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish all content datatable';

    /**
     * The console command module args.
     *
     * @var string
     */
    protected $module;

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
        //----------------------------------------Http---------------------------------------//
        'Factory/DatatableMaker.stub'                  => 'app/Http/Factory/DatatableMaker.php',
        //----------------------------------------Http---------------------------------------//
        'Factory/CustomDatatableMaker.stub'            => 'app/Http/Factory/CustomDatatableMaker.php',
        //---------------------------------------config--------------------------------------//
        'config/datatableModels.stub'                  => 'config/datatableModels.php',
        //----------------------------------------doc----------------------------------------//
        'datatable.md'                                 => 'datatable.md',
    ];

    /**
     * @return array
     *
     * empty for now
     */
    protected function setModuleFile()
    {
        return [

        ];
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        // Dir Files
        if (! is_dir(base_path('app/Http/Factory'))) {
            mkdir(base_path('app/Http/Factory'), 0755, true);
        }

        if (! is_dir(base_path('app/Factories'))) {
            mkdir(base_path('app/Factories'), 0755, true);
        }

        if(class_exists(\Module::class))
            foreach (\Module::all() as $module)
            {
                if (! is_dir(base_path("Modules/$module->name/Factories"))) {
                    mkdir(base_path("Modules/$module->name/Factories"), 0755, true);
                }
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

    protected function exportModuleFiles()
    {
        $this->loopFiles($this->setModuleFile());
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
        $this->module = ucfirst($this->argument('module'));

        $this->createDirectories();

        $this->exportFiles();

        if(!empty($this->module))
            $this->exportModuleFiles();

        $this->comment('DataTable scaffolding generated successfully!');
    }
}
