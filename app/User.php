<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * リレーション定義
     * ----------------------------------------------------------
     * 以下フレンド関係の方向性を表すため、接尾辞的に以下を使用
     * __to   : 自分 => 相手のフレンド関係
     * __from : 自分 <= 相手のフレンド関係
     */
    public function messages() {
        return $this->hasMany(Message::class, 'said_by');
    }
    public function threads() {
        return $this->belongsToMany(Thread::class, 'membership', 'user_id', 'thread_id')->withTimestamps();
    }
    public function items() {
        return $this->belongsToMany(Item::class, 'ordering', 'user_id', 'item_id')
                ->withPivot(['required_number'])
                ->withTimestamps();
    }
    public function friendships__to() {
        return $this->belongsToMany(User::class, 'friendship', 'user_id', 'target_id')->withTimestamps();
    }
    public function friendships__from() {
        return $this->belongsToMany(User::class, 'friendship', 'target_id', 'user_id')->withTimestamps();
    }
    
    /**
     * 承認待ちリクエスト（まだ承認してもらえてないフレンドリクエスト）
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function requests__to() {
        return $this->friendships__to()->wherePivot('is_accepted', false);
    }
    
    /**
     * フレンドリクエスト（自分に送られてきているフレンドリクエスト）
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function requests__from() {
        return $this->friendships__from()->wherePivot('is_accepted', false);
    }
    
    /**
     * 承認済みフレンド
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function friends() {
        // 承認済みフレンドのIDを配列として取得
        $friend_ids = array_unique(array_merge(
            $this->friendships__to()->wherePivot('is_accepted', true)->pluck('users.id')->toArray(),
            $this->friendships__from()->wherePivot('is_accepted', true)->pluck('users.id')->toArray()));
        
        // 承認済みフレンドに絞り込み
        return User::whereIn('id', $friend_ids);
    }
    
    /**
     * フレンドリクエスト送信
     * @return boolean
     */
    public function send_request_to($user_id) {
        if ($this->exists_friendship($user_id)) {
            return false;
        } else {
            $this->friendships__to()->attach($user_id, ['is_accepted' => false]);
            return true;
        }
    }
    
    /**
     * フレンドリクエスト承認
     * @return boolean
     */
    public function accept_request_from($user_id) {
        if ($this->requests__from()->where('users.id', $user_id)->exists()) {
            $this->requests__from()->updateExistingPivot($user_id, ['is_accepted' => true]);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * フレンド関係削除
     * @return boolean
     */
    public function delete_friendship($user_id) {
        if ($this->exists_friendship($user_id)) {
            $this->friendships__to()->detach($user_id);
            $this->friendships__from()->detach($user_id);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 既にフレンド関係（承認済みか否かにかかわらず）が存在するかどうか
     * @return boolean
     */
    public function exists_friendship($user_id) {
        return $this->friendships__to()->where('users.id', $user_id)->exists() || 
               $this->friendships__from()->where('users.id', $user_id)->exists();
    }
    
    public function belong_to($thread_id) {
        return $this->threads()->where('threads.id', $thread_id)->exists();
    }
}
