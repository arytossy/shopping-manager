<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Item;

class ItemController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'thread_id' => ['required'],
            'required_number' => ['required', 'numeric', 'min:1', 'max:10000'],
        ],[
            'name.required' => '品名は必須です',
            'name.max' => '品名が長すぎます',
            'thread_id.required' => '不正なリクエストです',
            'required_number.required' => '必要数は必須です',
            'required_number.numeric' => '必要数は数値です',
            'required_number.min' => '必要数は1以上です',
            'required_number.max' => '必要数は10000以下です',
        ]);
        $validator->validate();
        
        if (! \Auth::user()->belong_to($request->thread_id)) {
            $validator->errors()->add('thread_id', '対象スレッドが不正です');
            return back()->withErrors($validator)->withInput();
        }
        
        \Auth::user()->items()->create([
            'name' => $request->name,
            'is_shared' => $request->is_shared ? true : false,
            'bought_number' => 0,
            'thread_id' => $request->thread_id,
        ],[
            'required_number' => $request->required_number,
        ]);
        
        return back();
    }
    
    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'bought_number' => ['required', 'numeric', 'min:0', 'max:100000'],
        ],[
            'bought_number.required' => '購入数は必須です',
            'bought_number.numeric' => '購入数は数値です',
            'bought_number.min' => '購入数は0以上です',
            'bought_number.max' => '購入数は100000以下です',
        ]);
        $validator->validate();
        
        $item = Item::findOrfail($id);
        
        if (! \Auth::user()->belong_to($item->thread->id)) {
            abort(404);
        }
        
        $item->bought_number = $request->bought_number;
        $item->save();
        
        return back();
    }
    
    public function destroy($id) {
        $item = Item::findOrfail($id);
        
        if (! \Auth::user()->belong_to($item->thread->id)
                || ! $item->is_shared) {
            abort(404);
        }
        
        $item->delete();
        
        return back();
    }
}
