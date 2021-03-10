<?php

namespace App\Http\Resources;

use App\User;
use \App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_shared' => $this->is_shared,
            'bought_number' => $this->bought_number,
            'thread_id' => $this->thread_id,
            'required_total' => $this->get_total(),

            /**
             * 自分も欲しい！ボタンをrenderするかのフラグ
             * 初期値はtrueにしておき、VueComponent内で値を操作する
             */
            'me_too' => true,

            'users' => UserResource::collection($this->users),
        ];
    }
}
