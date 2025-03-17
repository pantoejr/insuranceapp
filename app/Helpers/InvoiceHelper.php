<?php

namespace App\Helpers;

class InvoiceHelper
{
     /**
      * Generate a custom invoice ID.
      *
      * @return string
      */
     public static function generateInvoiceId()
     {
          $randomNumber = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT); // Random 3-digit number
          $currentYear = date('Y'); // Current year
          return 'INV#' . $randomNumber . $currentYear; // Format: INV#1232023
     }
}
