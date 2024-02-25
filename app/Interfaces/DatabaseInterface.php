<?php

namespace App\Interfaces;

/**
 * DatabaseInterface Interface
 *
 * DatabaseInterface Interface is an interface for saving parsed data to the database.
 */
interface DatabaseInterface
{
    /**
     * Save the parsed data to the database.
     *
     * @param int $entityId
     * @param string $category
     * @param int $sku
     * @param string $name
     * @param string $description
     * @param string $shortDescription
     * @param float $price
     * @param string $link
     * @param string $image
     * @param string $brand
     * @param int $rating
     * @param string $caffeineType
     * @param int $count
     * @param Bool $flavored
     * @param Bool $seasonal
     * @param Bool $inStock
     * @param Bool $facebook
     * @param Bool $isKCup
     * @return string
     */
    function save(
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
        Bool $flavored,
        Bool $seasonal,
        Bool $inStock,
        Bool $facebook,
        Bool $isKCup
    ): string;
}
