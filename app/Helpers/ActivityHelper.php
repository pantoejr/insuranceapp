<?php

namespace App\Helpers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
     public static function log($type, $subject, $description = null, $properties = [])
     {
          if (is_null($description)) {
               $description = self::generateDescription($type, $subject);
          }

          return Activity::create([
               'type' => $type,
               'subject_id' => $subject->id,
               'subject_type' => get_class($subject),
               'description' => $description,
               'properties' => $properties,
               'user_id' => Auth::user()->id,
          ]);
     }

     protected static function generateDescription($type, $subject)
     {
          $types = [
               'policy_created' => 'New policy created: :subject',
               'claim_approved' => 'Claim approved: :subject',
               'policy_expiring' => 'Policy expiring soon: :subject',
               'policy_updated' => 'Policy updated: :subject'
          ];

          $template = $types[$type] ?? 'Activity: :subject';

          return str_replace(':subject', $subject->name ?? $subject->id, $template);
     }
}
