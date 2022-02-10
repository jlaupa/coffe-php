<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Domain;

class Utils
{
    public static function toArray($object): array
    {
        $output = [];
        foreach ((array) $object as $key => $value) {
            $key  = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
            $output[self::toSnakeCase($key)] = $value;
        }

        return $output;
    }

    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $text));
    }
}