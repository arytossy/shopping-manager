<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Message;
use App\Thread;

class MessageController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'max:255'],
            'thread_id' => ['required'],
        ],[
            'content.required' => 'メッセージ内容は必須です',
            'content.max' => 'メッセージが長すぎます',
            'thread_id.required' => '不正なリクエストです',
        ]);
        $validator->validate();
        
        if (! \Auth::user()->belong_to($request->thread_id)) {
            $validator->errors()->add('thread_id', '対象スレッドが不正です');
            return back()->withErrors($validator)->withInput();
        }
        
        \Auth::user()->messages()->create([
            'content' => $request->content,
            'thread_id' => $request->thread_id,
        ]);
        
        return back();
    }
    
    public function destroy($id) {
        $message = \Auth::user()->messages()->findOrFail($id);
        
        $message->delete();
        
        return back();
    }
}
