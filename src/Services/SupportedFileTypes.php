<?php

namespace App\Services;

final class SupportedFileTypes
{
      const FILE_TYPES = ['csv']; 

      public static function isSupportedFileType(string $type)
      {
        return in_array($type, self::FILE_TYPES);
      }
}