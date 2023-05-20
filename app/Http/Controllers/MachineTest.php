<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Balls;
use App\Models\Buckets;

class MachineTest extends Controller
{
    public function dashboard()
    {


        $balls = Balls::all();
        $buckets = Buckets::all();
        $tests= Test::all();
        $bucketsList = [];
        $ballsList = [];
        foreach($balls as $k=>$ball) {
            $ballsList[$ball->id] = $ball->name;
        }
        foreach($buckets as $k=>$bucket) {
            $bucketsList[$bucket->id] = $bucket->name;
        }
        return  view("dashboard", compact('buckets', 'balls', 'tests', 'ballsList', 'bucketsList'));
    }
    public function add_ball()
    {

        return  view("add_balls");
    }
    public function add_bucket()
    {

        return  view("add_buckets");
    }
    public function edit_bucket($id)
    {

        $bucket = Buckets::where('id', $id)->get();
        return  view("edit_buckets", compact('bucket'));
    }
    public function edit_ball($id)
    {

        $ball = Balls::where('id', $id)->get();

        return  view("edit_balls", compact('ball'));
    }
    public function store_ball(Request $req, $id=false)
    {
        $req->validate([
            'name' => 'required',
            'volume' => 'required',
        ]);
        $obj = new Balls();
        if($id) {
            $obj = Balls::find($id);
        }
        $obj->name = $req->post('name');
        $obj->volume = $req->post('volume');
        $req->session()->flash('status', 'success');
        if($id) {
            $obj->update();
            $req->session()->flash('msg', "Balls are updated successful!");

        } else {
            $obj->save();
            $req->session()->flash('msg', "Balls are added successful!");

        }
        Buckets::query()->update(['filled_volume'=>0]);
        Test::query()->delete();

        //

        return  redirect("/");
    }

    public function store_bucket(Request $req, $id=false)
    {
        $req->validate([
            'name' => 'required',
            'volume' => 'required',
        ]);
        $obj = new Buckets();
        if($id) {
            $obj = Buckets::find($id);
        }
        $obj->name = $req->post('name');
        $obj->volume = $req->post('volume');
        $obj->filled_volume = 0;
        $req->session()->flash('status', 'success');
        if($id) {
            $obj->update();
            $req->session()->flash('msg', "Buckets are updated successful! and all bucket gets emptied");

        } else {
            $obj->save();
            $req->session()->flash('msg', "Buckets are added successful! and all bucket gets emptied");
        }
        $obj = new Buckets();
        $obj->filled_volume = 0;
        $obj->update();
        //
        return  redirect("/");
    }
    public function test(Request $req)
    {
        $req->validate([
            'buckets_id' => 'required',
            'balls_id' => 'required',
            'numbers_of_ball' => 'required',
        ]);
        $obj = new Test();
        $obj->buckets_id = $req->post('buckets_id');
        $obj->balls_id = $req->post('balls_id');
        $obj->numbers_of_ball = $req->post('numbers_of_ball');
        $ball = Balls::find($req->post('balls_id'));
        $obj1 = Buckets::find($req->post('buckets_id'));


        echo $remaining = $obj1->volume - $obj1->filled_volume;
        echo $newTotal = $req->post('numbers_of_ball') * $ball->volume;
        if($newTotal > $remaining) {
            $noOfBalls = (int) $remaining/$ball->volume;
            $obj->numbers_of_ball =  $noOfBalls;
            $obj1->filled_volume = $obj1->filled_volume + ($noOfBalls * $ball->volume);
            $req->session()->flash('status', 'error');
            if($noOfBalls) {
                $req->session()->flash('msg', "Only $noOfBalls balls are added in bucket successful!");
            } else {
                $req->session()->flash('msg', "Sorry No balls are added in bucket !");
                return  redirect("/");
            }

        } else {
            $req->session()->flash('status', 'success');
            $obj1->filled_volume = $obj1->filled_volume + ($req->post('numbers_of_ball') * $ball->volume);
            $req->session()->flash('msg', "All balls are added in bucket successful!");
        }


        $obj->save();
        $obj1->update();
        return  redirect("/");
    }
}
