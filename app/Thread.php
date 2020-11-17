<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * createメソッドを利用可能に
     */
    protected $fillable = [
        'title', 'where_go', 'when_go',
    ];
    
    /**
     * リレーション定義
     */
    public function items() {
        return $this->hasMany(Item::class, 'thread_id');
    }
    public function messages() {
        return $this->hasMany(Message::class, 'thread_id');
    }
    public function members() {
        return $this->belongsToMany(User::class, 'membership', 'thread_id', 'user_id')->withTimestamps();
    }
    
    /**
     * メンバー追加
     * @reteurn integer 登録レコード数
     */
    public function add_members(...$user_ids) {
        // 有効かつメンバー未登録のユーザーIDに絞り込み
        $new_member_ids = array_unique(array_filter(function ($id) {
            return User::where('id', $id)->exists()
                        && !$this->members()->where('id', $id)->exists();
        }));
        
        // メンバー登録
        if (count($new_member_ids)) {
            $this->members()->attach($new_member_ids);
            return count($new_member_ids);
        } else {
            return 0;
        }
    }
    
    /**
     * メンバー除名
     * 一人ずつしかできない
     * @return boolean
     */
    public function delete_member($user_id) {
        if (User::where('id', $user_id)->exists()
                && $this->members()->where('id', $user_id)->exists()) {
                    
            $this->members()->detach($user_id);
            return true;
            
        } else {
            return false;
        }
    }
}
