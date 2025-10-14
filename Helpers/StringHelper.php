<?php

namespace Helpers;

class StringHelper
{
    /**
     * Truncates a string to a max length without breaking words.
     */
    public static function truncate(string $string, int $maxLength = 55): string
    {
        if (strlen($string) <= $maxLength) {
            return $string;
        }

        $truncated = substr($string, 0, $maxLength);
        $lastSpace = strrpos($truncated, ' ');

        if ($lastSpace === false) {
            return substr($string, 0, $maxLength) . '...';
        }

        return substr($truncated, 0, $lastSpace) . '...';
    }

    /**
     * Converts a timestamp to a "time ago" string.
     */
    public static function time_ago(string $timestamp): string
    {
        $diff = time() - strtotime($timestamp);
        if ($diff < 60) return $diff . ' seconds ago';
        if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        return floor($diff / 86400) . ' days ago';
    }
}
