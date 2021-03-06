<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Thread;

class MemberController extends Controller
{
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'thread_id' => ['required'],
            'members' => ['required', 'array'],
        ]);
        $validator->validate();
        
        $thread = \Auth::user()->threads()->find($request->thread_id);
        
        if (! $thread) {
            $validator->errors()->add('thread_id', '対象スレッドが不正です');
            return back()->withErrors($validator)->withInput();
        } 
        
        foreach ($request->members as $val) {
            $new_member_ids[] = (int) $val;
        }
        $thread->add_members($new_member_ids);
        
        return back();
    }
    
    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'thread_id' => ['required'],
            'user_id' => ['required'],
        ]);
        $validator->validate();
        
        $thread = \Auth::user()->threads()->find($request->thread_id);
        
        if (! $thread) {
            $validator->errors()->add('thread_id', '対象スレッドが不正です');
            return back()->withErrors($validator)->withInput();
        } 
        
        $result = $thread->delete_member($request->user_id);
        
        if (! $result) {
            $validator->errors()->add('user_id', '削除に失敗しました');
            return back()->withErrors($validator)->withInput();
        }
        
        if ($thread->members()->count() == 0) {
            $thread->delete();
        }
        
        if (\Auth::id() == $request->user_id) {
            return redirect()->route('threads.index');
        } else {
            return back();
        }
    }
}
