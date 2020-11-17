<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * createメソッドを利用可能に
     */
    protected $fillable = [
        'content', 'fhread_id', 'said_by',
    ];
    
    /**
     * リレーション定義
     */
    public function user() {
        return $this->belongsTo(User::class, 'said_by');
    }
    public function thread() {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}
