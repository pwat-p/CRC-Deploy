<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditlog extends Model
{
    const UPDATED_AT = null;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function log($action, $user_id, $source, $object)
    {
        $log = new Auditlog();
        $log->action = $action;
        $log->user_id = $user_id;
        $log->source = $source;
        $log->object = $object;
        $log->save();
    }
}
