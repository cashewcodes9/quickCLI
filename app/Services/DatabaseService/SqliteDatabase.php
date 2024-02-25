<?php

namespace App\Services\DatabaseService;

use App\Interfaces\DatabaseInterface;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SqliteDatabase Class
 *
 * SqliteDatabase Class is a class for saving parsed data to the sqlite database.
 */
class SqliteDatabase implements DatabaseInterface
{
    /**
     * SqliteDatabase constructor.
     */
    public function __construct()
    {
        // setting connection to sqlite database.
        DB::connection('sqlite');
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
        try {
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
            return 'Data saved to sqlite database.';
        } catch (UniqueConstraintViolationException|\Exception $e ) {
            Log::error('Error while saving data to sqlite database: ' . $e->getMessage());
            throw $e;
        }
    }
}
