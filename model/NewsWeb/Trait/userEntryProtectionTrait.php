<?php

namespace NewsWeb\Trait;

trait userEntryProtectionTrait
{
    public static function userEntryProtection(
        string            $entry,
        int               $flags = ENT_QUOTES,
        string            $characters = " \n\r\t\v\0",
        array|string|null $allowed_tags = null,
        ?string           $encoding = "UTF-8",
        bool              $double_encode = true
    ): string
    {
        return trim(htmlspecialchars(strip_tags($entry, $allowed_tags), $flags, $encoding, $double_encode), $characters);
    }
}