<?php

namespace App\Http\Controllers;

use App\Events\MemberAdded;
use App\Events\MemberDeleted;
use App\Events\ThreadUpdated;
use App\Rules\HasCurrentUser;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @return json
     */
    public function index(Request $request) {
        $request->validate([
            'thread_id' => ['required', new HasCurrentUser],
        ]);

        $members = Thread::find($request->thread_id)->members;

        return $members;
    }

    public function add(Request $request) {
        $request->validate([
            'thread_id' => ['required', new HasCurrentUser],
            'members' => ['required', 'array'],
            'members.*' => [
                function ($attribute, $value, $fail) {
                    if (!\Auth::user()->friends()->where('users.id', $value)->exists()) {
                        $fail('存在しない友だちです');
                    }
                },
            ],
        ]);
        
        foreach ($request->members as $val) {
            $new_member_ids[] = (int) $val;
        }

        $thread = Thread::find($request->thread_id);
        $new_members = $thread->add_members($new_member_ids);

        event(new MemberAdded($new_members, $thread->id));
        event(new ThreadUpdated($thread));
        
        return null;
    }
    
    public function destroy(Request $request) {
        $request->validate([
            'thread_id' => ['required', new HasCurrentUser],
            'user_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!User::where('id', $value)->exists()) {
                        $fail('このスレッドに存在しないユーザーです');
                    }
                }
            ],
        ]);
        
        $thread = Thread::find($request->thread_id);
        $deleted_member = $thread->delete_member($request->user_id);

        // 最後の一人だった場合はスレッド自体も削除
        if ($thread->members()->count() == 0) {
            $thread->delete();
        } else {
            event(new ThreadUpdated($thread));
            event(new MemberDeleted($deleted_member, $thread->id));
        }
        
        // 自分が退出する場合はスレッド一覧にリダイレクト
        if (\Auth::id() == $request->user_id) {
            return redirect()->route('threads.index');
        } else {
            return null;
        }
    }
}
