<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // Contoh: php artisan make:service TahunAktif --dto --controller=V2/TahunAktifController

    // php artisan make:service {name} --dto --controller={controller}

    protected $signature = 'make:service {name} {--controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Service Class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Make {name} Folder
            $name = $this->argument('name');
            $folder = app_path('Services/' . $name);
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/Interfaces Folder
            $folder = app_path('Services/' . $name . '/Interfaces');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/Interfaces/{name}ServiceInterface.php
            $file = app_path('Services/' . $name . '/Interfaces/' . $name . 'ServiceInterface.php');
            if (!file_exists($file)) {
                $this->makeServiceInterfaceFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/Interfaces/{name}RepositoryInterface.php
            $file = app_path('Services/' . $name . '/Interfaces/' . $name . 'RepositoryInterface.php');
            if (!file_exists($file)) {
                $this->makeRepositoryInterfaceFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/{name}Service.php
            $file = app_path('Services/' . $name . '/' . $name . 'Service.php');
            if (!file_exists($file)) {
                $this->makeServiceFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/{name}Repository.php
            $file = app_path('Services/' . $name . '/' . $name . 'Repository.php');
            if (!file_exists($file)) {
                $this->makeRepositoryFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/Dto Folder
            $folder = app_path('Services/' . $name . '/Dto');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/Dto/{name}Dto.php
            $file = app_path('Services/' . $name . '/Dto/' . $name . 'Dto.php');
            if (!file_exists($file)) {
                $this->makeDtoFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Append {name}ServiceInterface to app\Providers\V2\ServiceConfigProvider.php
            $file = app_path('Providers/ServiceConfigProvider.php');
            $this->appendServiceInterface($file, $name);

            // Run composer dump-autoload
            exec('composer dump-autoload');

            // Make Dto
            $this->call('make:dto', [
                'name' => $name
            ]);

            // Make Controller

            if ($this->option('controller')) {
                $this->call('make:controller', [
                    'name' =>  $name . 'Controller',
                    '--api' => true
                ]);
            }

            $this->info('All done.');
            $this->info('Thank you. Have a nice day! by: yondaime :)');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 0;
        }
    }

    public function makeDtoFile($file, $name)
    {
        $file = fopen($file, "w");
        $txt = "<?php\n\n";
        $txt .= "namespace App\Services\\" . $name . "\Dto;\n\n";
        $txt .= "class " . $name . "Dto\n";
        $txt .= "{\n";
        $txt .= "}\n";
        fwrite($file, $txt);
        fclose($file);

        $this->info($name . 'Dto.php created successfully.');
    }

    public function appendServiceInterface($path, $name)
    {
        $file = fopen($path, "r");
        $txt = fread($file, filesize($path));
        fclose($file);

        $txt = str_replace("}\n}", "", $txt);
        $txt .= "        // " . $name . "\n";
        $txt .= "        $" . "this->app->bind(\App\Services\\" . $name . "\\Interfaces\\" . $name . "ServiceInterface::class, \App\Services\\" . $name . "\\" . $name . "Service::class);\n";
        $txt .= "        $" . "this->app->bind(\App\Services\\" . $name . "\\Interfaces\\" . $name . "RepositoryInterface::class, \App\Services\\" . $name . "\\" . $name . "Repository::class);\n";
        $txt .= "    }\n";
        $txt .= "}\n";

        $file = fopen($path, "w");
        fwrite($file, $txt);
        fclose($file);


        $this->info($name . 'ServiceInterface.php append to Service Config Provider successfully.');
    }

    public function makeServiceFile($file, $name)
    {
        $file = fopen($file, "w");
        $txt = "<?php\n\n";
        $txt .= "namespace App\Services\\" . $name . ";\n\n";
        $txt .= "use App\Services\\" . $name . "\\Interfaces\\" . $name . "RepositoryInterface;\n";
        $txt .= "use App\Services\\" . $name . "\\Interfaces\\" . $name . "ServiceInterface;\n";
        $txt .= "use Illuminate\Http\Request;\n\n";
        $txt .= "class " . $name . "Service implements " . $name . "ServiceInterface\n";
        $txt .= "{\n";
        $txt .= "    protected $" . strtolower($name) . "RepositoryInterface;\n\n";
        $txt .= "    public function __construct(" . $name . "RepositoryInterface $" . strtolower($name) . "RepositoryInterface)\n";
        $txt .= "    {\n";
        $txt .= "        $" . "this->" . strtolower($name) . "RepositoryInterface = $" . strtolower($name) . "RepositoryInterface;\n";
        $txt .= "    }\n\n";
        $txt .= "}\n";
        fwrite($file, $txt);
        fclose($file);

        $this->info($name . 'Service.php created successfully.');
    }

    public function makeRepositoryFile($file, $name)
    {
        $file = fopen($file, "w");
        $txt = "<?php\n\n";
        $txt .= "namespace App\Services\\" . $name . ";\n\n";
        $txt .= "use App\Services\\" . $name . "\\Interfaces\\" . $name . "RepositoryInterface;\n";
        $txt .= "use Illuminate\Http\Request;\n\n";
        $txt .= "class " . $name . "Repository implements " . $name . "RepositoryInterface\n";
        $txt .= "{\n";
        $txt .= "}\n";
        fwrite($file, $txt);
        fclose($file);

        $this->info($name . 'Repository.php created successfully.');
    }

    public function makeServiceInterfaceFile($file, $name)
    {
        $file = fopen($file, "w");
        $txt = "<?php\n\n";
        $txt .= "namespace App\Services\\" . $name . "\Interfaces;\n\n";
        $txt .= "interface " . $name . "ServiceInterface\n";
        $txt .= "{\n";
        $txt .= "}\n";
        fwrite($file, $txt);
        fclose($file);

        $this->info($name . 'ServiceInterface.php created successfully.');
    }

    public function makeRepositoryInterfaceFile($file, $name)
    {
        $file = fopen($file, "w");
        $txt = "<?php\n\n";
        $txt .= "namespace App\Services\\" . $name . "\Interfaces;\n\n";
        $txt .= "interface " . $name . "RepositoryInterface\n";
        $txt .= "{\n";
        $txt .= "}\n";
        fwrite($file, $txt);
        fclose($file);

        $this->info($name . 'RepositoryInterface.php created successfully.');
    }
}
