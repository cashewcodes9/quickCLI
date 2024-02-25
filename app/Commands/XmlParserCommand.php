<?php

namespace App\Commands;

use App\Exceptions\InvalidDatabaseException;
use App\Exceptions\InvalidXmlException;
use App\Services\DatabaseService\DatabaseService;
use App\Services\DatabaseService\MysqlDatabase;
use App\Services\DatabaseService\PostgresDatabase;
use App\Services\DatabaseService\SqliteDatabase;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use LaravelZero\Framework\Commands\Command;

/**
 * XmlParserCommand Class
 *
 * XmlParserCommand Class is a command class used to parse and store xml data into different databases.
 *
 * If a user missed a required argument, implementing PromptsForMissingInput will prompt the user to enter missing argument after showing an error.
 */
class XmlParserCommand extends Command implements PromptsForMissingInput
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'parse:xml
        {xml : The name of xml file to parse. (please move your xml file to application root directory)}
        {--db=sqlite : The type of database you want to save parsed data in. available options: sqlite (default), mysql, postgres}
        ';

    /**
     * Prompt for missing input arguments using the returned questions.
     * @return string[]
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
          'xml' => ['Which xml file would you like to parse and save in database?', 'E.g. example.xml'],
        ];
    }

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Parse the xml file and save data in a database of your choice.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $startTime = Carbon::now()->toDateTimeString();

            $this->info('Welcome to the XML Parser Command');
            $this->newLine(1);
            $this->info('You are about to parse the following xml file: ' . $this->argument('xml'));

            $this->newLine(1);
            $this->info('Checking database type...');
            $db = $this->option('db');
            throw_if(!in_array($db, ['sqlite', 'mysql', 'postgres']), new InvalidDatabaseException());

            $this->newLine(1);
            $this->info('Valid database type. Database type: ' . $db);

            $this->newLine(1);
            $this->info('The parsing of your data is about to start. Please wait...');
            $this->newLine(1);

            // Throw an error if the xml file is not found or has invalid data.
            $xml = simplexml_load_file($this->argument('xml'));
            throw_if($xml == false, new InvalidXmlException());

            // logging the execution of the command.
            Log::info(sprintf('parse_request::xml::begin || Filename: %s || database: %s || Time of execution: %s', $this->argument('xml'), $db, $startTime));

            $this->info('Data parsing is complete. Saving data to database...');
            $this->newLine(1);

            // Loop through the xml data and save it to the database.
            $this->withProgressBar($xml->children(), function ($product) use ($db) {
                $entityId = (int) $product->entity_id;
                $category = $product->CategoryName;
                $sku = (int) $product->sku;
                $name = $product->name;
                $description = $product->description;
                $shortDescription = $product->shortdesc;
                $price = (float) $product->price;
                $link = $product->link;
                $image = $product->image;
                $brand = $product->Brand;
                $rating = (int) $product->Rating;
                $caffeineType = $product->CaffeineType;
                $count = (int) $product->Count;
                $flavored = (bool) $product->Flavored;
                $seasonal = (bool) $product->Seasonal;
                $inStock = (bool) $product->Instock;
                $facebook = (bool) $product->Facebook;
                $isKCup = (bool) $product->IsKCup;

                if ($db === 'sqlite') {
                    (new DatabaseService( new SqliteDatabase()))
                        ->save(
                            $entityId,
                            $category,
                            $sku,
                            $name,
                            $description,
                            $shortDescription,
                            $price,
                            $link,
                            $image,
                            $brand,
                            $rating,
                            $caffeineType,
                            $count,
                            $flavored,
                            $seasonal,
                            $inStock,
                            $facebook,
                            $isKCup
                        );
                } elseif ($db === 'mysql') {
                    (new DatabaseService( new MysqlDatabase()))
                        ->save(
                            $entityId,
                            $category,
                            $sku,
                            $name,
                            $description,
                            $shortDescription,
                            $price,
                            $link,
                            $image,
                            $brand,
                            $rating,
                            $caffeineType,
                            $count,
                            $flavored,
                            $seasonal,
                            $inStock,
                            $facebook,
                            $isKCup
                        );
                } elseif ($db === 'postgres') {
                    (new DatabaseService( new PostgresDatabase()))
                        ->save(
                            $entityId,
                            $category,
                            $sku,
                            $name,
                            $description,
                            $shortDescription,
                            $price,
                            $link,
                            $image,
                            $brand,
                            $rating,
                            $caffeineType,
                            $count,
                            $flavored,
                            $seasonal,
                            $inStock,
                            $facebook,
                            $isKCup,
                        );
                }
            });
            $endTime = now()->toDateTimeString();
            $this->newLine(2);
            $this->info('Congratulations. Data has been successfully saved to the database.');
            Log::info(sprintf('id: parse_request::xml::end || Filename: %s || database: %s || Time of execution: %s || Elapsed time: %s', $this->argument('xml'), $db, $endTime, Carbon::parse($startTime)->diffAsCarbonInterval($endTime)));

        } catch (InvalidDatabaseException| InvalidXmlException|Exception $e) {
            Log::error($e->getMessage());
            $this->newLine(1);
            $this->error('Error occurred. || ' . $e->getMessage());
            $this->newLine(1);
            $this->info('Please check the error log for more details and try again.');
        }
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
