<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateUpdateDto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dto {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create DTO Class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $name = $this->argument('name');

            // Make {name}/Dto/Create{name}Dto.php
            $file = app_path('Services/' . $name . '/Dto/Create' . $name . 'Dto.php');
            if (!file_exists($file)) {
                $this->makeCreateDtoFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            // Make {name}/Dto/Update{name}Dto.php
            $file = app_path('Services/' . $name . '/Dto/Update' . $name . 'Dto.php');
            if (!file_exists($file)) {
                $this->makeUpdateDtoFile($file, $name);
            } else {
                throw new \Exception('Service ' . $name . ' already exists.');
            }

            $this->info('Service ' . $name . ' created successfully.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function makeCreateDtoFile($file, $name)
    {
        // Only create namespace, class, constructor, and toArray method
        $content = "<?php" . PHP_EOL . PHP_EOL;
        $content .= "namespace App\Services\\" . $name . "\\Dto;" . PHP_EOL . PHP_EOL;
        $content .= "use App\Traits\Validation;" . PHP_EOL . PHP_EOL;
        $content .= "class Create" . $name . "Dto" . PHP_EOL;
        $content .= "{" . PHP_EOL;
        $content .= "use Validation;" . PHP_EOL . PHP_EOL;
        $content .= $this->makeConstructor($name);
        $content .= $this->makeToArray($name);
        $content .= $this->makeValidate($name);
        $content .= "}";
        file_put_contents($file, $content);
    }

    private function makeUpdateDtoFile($file, $name)
    {
        $content = "<?php" . PHP_EOL . PHP_EOL;
        $content .= "namespace App\Services\\" . $name . "\\Dto;" . PHP_EOL . PHP_EOL;
        $content .= "use App\Traits\Validation;" . PHP_EOL . PHP_EOL;
        $content .= "class Update" . $name . "Dto" . PHP_EOL;
        $content .= "{" . PHP_EOL;
        $content .= "use Validation;" . PHP_EOL . PHP_EOL;
        $content .= "\tprivate string $" . "id;" . PHP_EOL;
        $content .= $this->makeConstructor($name);
        $content .= $this->makeToArray($name);
        $content .= $this->makeValidate($name);
        $content .= "}";
        file_put_contents($file, $content);
    }

    private function makeConstructor($name)
    {
        $content = "\tpublic function __construct(" . PHP_EOL;
        $content .= "\t) {" . PHP_EOL;
        $content .= "\t}" . PHP_EOL . PHP_EOL;
        return $content;
    }

    private function makeToArray($name)
    {
        $content = "\tpublic function toArray(): array" . PHP_EOL;
        $content .= "\t{" . PHP_EOL;
        $content .= "\t\treturn [" . PHP_EOL;
        $content .= "\t\t];" . PHP_EOL;
        $content .= "\t}" . PHP_EOL . PHP_EOL;
        return $content;
    }

    private function makeValidate($name)
    {
        $content = "\tpublic function validate(): void" . PHP_EOL;
        $content .= "\t{" . PHP_EOL;
        $content .= "\t\t$" . "data = [];" . PHP_EOL;
        $content .= "\t\t$" . "rules = [];" . PHP_EOL;
        $content .= "\t\t$" . "messages = [];" . PHP_EOL;
        $content .= "\t$" . "this->validateData($" . "data, $" . "rules, $" . "messages);" . PHP_EOL;
        $content .= "\t}" . PHP_EOL . PHP_EOL;
        return $content;
    }
}
