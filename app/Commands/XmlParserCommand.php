<?php

namespace App\Commands;

use App\Services\DatabaseService\DatabaseService;
use App\Services\DatabaseService\MysqlDatabase;
use App\Services\DatabaseService\PostgresDatabase;
use App\Services\DatabaseService\SqliteDatabase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\PromptsForMissingInput;
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
        $db = $this->option('db');
        $xml = simplexml_load_file($this->argument('xml')) or die('Error: Cannot create xml object');

        foreach ($xml->children() as $product) {
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
                        $isKCup
                    );
            } else {
                $this->error('Invalid database type. Please use --db option to specify a valid database type.');
            }
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
