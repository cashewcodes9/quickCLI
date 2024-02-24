<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;
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
            $entityId = $product->entity_id;
            $category = $product->CategoryName;
            $sku = $product->sku;
            $name = $product->name;
            $description = $product->description;
            $shortDescription = $product->shortdesc;
            $price = $product->price;
            $link = $product->link;
            $image = $product->image;
            $brand = $product->Brand;
            $rating = $product->Rating;
            $caffeineType = $product->CaffeineType;
            $count = $product->Count;
            $flavored = $product->Flavored;
            $seasonal = $product->Seasonal;
            $inStock = $product->Instock;
            $facebook = $product->Facebook;
            $isKCup = $product->IsKCup;


            DB::table('products')->insert(
              [
                  'id' => $entityId,
                  'category' => $category,
                  'sku' => $sku,
                  'name' => $name,
                  'description' => $description,
                  'short_description' => $shortDescription,
                  'price' => $price,
                  'link' => $link,
                  'image' => $image,
                  'brand' => $brand,
                  'rating' => $rating,
                  'caffeine_type' => $caffeineType,
                  'count' => $count,
                  'flavored' => $flavored,
                  'seasonal' => $seasonal,
                  'in_stock' => $inStock,
                  'facebook' => $facebook,
                  'is_k_cup' => $isKCup,
              ]
            );
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
