<?php

namespace App\Service\Blog;

class ReadingTimeService
{
    const int AVERAGE_READING_SPEED_WORDS_PER_MINUTE = 230;

    public static function calculate(string $text): int
    {
        // Split the text into words
        $words = str_word_count(strip_tags($text));

        // Calculate reading time in minutes
        $readingTime = ceil($words / self::AVERAGE_READING_SPEED_WORDS_PER_MINUTE);

        return $readingTime;
    }
}
