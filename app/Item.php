<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * createメソッドを利用可能に
     */
    protected $fillable = [
        'name', 'is_shared', 'bought_number',
    ];
    
    /**
     * リレーション定義
     */
    public function thread() {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
    public function users() {
        return $this->belongsToMany(User::class, 'ordering', 'item_id', 'user_id')
                        ->withPivot(['required_number'])
                        ->withTimestamps();
    }
    
    /**
     * ほしい数の合計
     * @return int
     */
    public function get_total() {
        return (int) \DB::table('ordering')
                        ->where('item_id', $this->id)
                        ->sum('required_number');
    }
    
    /**
     * 他のユーザーが頼んだものに便乗
     * @return boolean
     */
    public function add_order_by($user_id) {
        if ($this->users()->where('users.id', $user_id)->exists()) {
            return false;
        } else {
            $this->users()->attach($user_id, ['required_number' => 1]);
            return true;
        }
    }
    
    /**
     * この品目を頼むのをやめる
     * @return boolean
     */
    public function cancel_order_by($user_id) {
        if ($this->users()->where('users.id', $user_id)->exists()) {
            $this->users()->detach($user_id);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * ほしい数を変更
     * @return boolean
     */
    public function change_required_number($number, $user_id) {
        if ($this->users()->where('users.id', $user_id)->exists()) {
            return false;
        } else {
            $this->users()->updateExistingPivot($user_id, ['required_number' => $number]);
            return true;
        }
    }
}
