<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

/**
 * JsonParserCommand Class
 *
 * JsonParserCommand Class is a command class used to parse and store json data into different databases.
 *
 * If a user missed a required argument, implementing PromptsForMissingInput will prompt the user to enter missing argument after showing an error.
 */
class JsonParserCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'parse:json
        {json : The name of json file to parse. (please move your json file to application root directory)}
        {--db=sqlite : The type of database you want to save parsed data in. available options: sqlite (default), mysql, postgres}
    ';

    /**
     * Prompt for missing input arguments using the returned questions.
     * @return string[]
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'json' => ['Which json file would you like to parse and save in database?', 'E.g. example.json'],
        ];
    }


    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Parse the json file and save data in a database of your choice.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $db = $this->option('db');
        //$json = json_decode(file_get_contents($this->argument('json')), true);
        $this->info('This is a demo command. Please implement your logic to parse and save data in database.');

        /*foreach ($json as $product) {
            $this->info('Parsing product: ' . $product['name']);
            $this->info('Saving product to database: ' . $product['name']);
        }*/
    }

    /**
     * Define the command's schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
