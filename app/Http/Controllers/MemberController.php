<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class MemberController extends Controller
{
    public function add(Request $request) {
        $thread = Thread::findOrFail($request->thread_id);
        
        foreach ($request->members as $val) {
            $new_member_ids[] = (int) $val;
        }
        $thread->add_members($new_member_ids);
        
        return back();
    }
    
    public function destroy(Request $request) {
        $thread = Thread::findOrFail($request->thread_id);
        
        $thread->delete_member($request->user_id);
        
        return back();
    }
}
