<?php

namespace Denysovvl\EasyCollector\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class CreateCollectorCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:collector';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new collector';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Collector';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument model name");
        }

        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyCollector', $this->argument('name'), $stub);
    }

    /**
     *
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  base_path('vendor/denysovvl/easy-collector/src/stubs/Collector.stub');
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Collectors';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model class.'],
        ];
    }
}
