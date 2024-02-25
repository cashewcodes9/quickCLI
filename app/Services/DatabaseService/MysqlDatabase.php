<?php

namespace App\Services\DatabaseService;

use App\Interfaces\DatabaseInterface;
use Illuminate\Support\Facades\DB;

/**
 * SqliteDatabase Class
 *
 * SqliteDatabase Class is a class for saving parsed data to the sqlite database.
 */
class MysqlDatabase implements DatabaseInterface
{
    /**
     * SqliteDatabase constructor.
     */
    public function __construct()
    {
        // setting connection to mysql database.
        DB::connection('mysql');
    }

    /**
     * @inheritDoc
     */
    public function save(
        int $entityId,
        string $category,
        int $sku,
        string $name,
        string $description,
        string $shortDescription,
        float $price,
        string $link,
        string $image,
        string $brand,
        int $rating,
        string $caffeineType,
        int $count,
        bool $flavored,
        bool $seasonal,
        bool $inStock,
        bool $facebook,
        bool $isKCup
    ): string
    {
        // TODO: use try catch block to catch any exceptions. And do logging.

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
                'is_k_cup' => $isKCup
            ]
        );

        return 'Data saved to mysql database.';
    }
}
