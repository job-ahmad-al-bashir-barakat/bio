<?php

namespace Aut\DataTable\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class FactoryMakeCommand extends Command
{
    use GeneratorCommand;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datatable:factory 
        {name : The name of the factory.} 
        {module? : The moudle of modules will be create factory on it.}
        {--resource=true : Generate a resource factory class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new factory class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('resource') == "true") {
            return __DIR__.'/stubs/make/Factory/factory.stub';
        }

        return __DIR__.'/stubs/make/Factory/factory.plain.stub';
    }

    /**
     * Replace the param model name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceParameter(&$stub, $search = [] ,$replace = [])
    {
        $stub = str_replace(
            $search,
            $replace,
            $stub
        );

        return $this;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $module = $this->argument('module');

        $Module = ucfirst($module);

        if($module != '')
            return $rootNamespace."\\Modules\\$Module\\Factories";
        else
            return $rootNamespace.'\Factories';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function parentBuildClass($name)
    {
        $module = $this->argument('module');

        $stub = $this->files->get($this->getStub());

        if($module != '')
            $name = preg_replace("/App\\\/",'' ,$name);

        $model = preg_replace('/(.+\\\\)|(factory)/i' ,'' ,$name);

        return $this->replaceParameter($stub ,['DummyModel'],[$model])->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $module = $this->argument('module');

        $namespace = $this->getNamespace($name);

        if($module != '')
            $namespace = preg_replace("/App\\\/",'' ,$this->getNamespace($name));

        return str_replace("use $namespace\Factories;\n", '', $this->parentBuildClass($name));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument('module');

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        if($module != '')
        {
            $path = base_path(preg_replace("/App\\\/",'' ,$name)).'.php';

            if(file_exists($path)) {
                $this->error($this->type.' already exists!');

                return false;
            }
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
    }
}
