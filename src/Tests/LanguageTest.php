<?php

namespace App\Tests;

use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    public function isTrueTest()
    {
        $lang =new Language();
        $lang->getTitle();
        self::assertIsString($lang);
    }
}