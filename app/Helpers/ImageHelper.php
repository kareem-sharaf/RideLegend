<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get image URL with fallback to placeholder
     */
    public static function getImageUrl(?string $path, string $type = 'bike'): string
    {
        if (!$path) {
            return self::getPlaceholderUrl($type);
        }

        // Check if file exists
        $fullPath = storage_path('app/public/' . $path);
        if (file_exists($fullPath)) {
            return asset('storage/' . $path);
        }

        // Fallback to placeholder
        return self::getPlaceholderUrl($type);
    }

    /**
     * Get placeholder image URL based on type
     */
    public static function getPlaceholderUrl(string $type = 'bike'): string
    {
        $placeholders = [
            'bike' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
            'road' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
            'mountain' => 'https://images.unsplash.com/photo-1571068316344-75bc76f77890?w=800&h=600&fit=crop',
            'electric' => 'https://images.unsplash.com/photo-1571066811602-716837d681de?w=800&h=600&fit=crop',
        ];

        return $placeholders[$type] ?? $placeholders['bike'];
    }
}

