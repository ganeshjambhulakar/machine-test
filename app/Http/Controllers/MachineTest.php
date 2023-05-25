<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Balls;
use App\Models\Buckets;

use function Psy\debug;

class MachineTest extends Controller
{
    public function dashboard()
    {


        $balls = Balls::all();
        $buckets = Buckets::all();
        $tests = Test::all();
        $bucketsList = [];
        $ballsList = [];
        foreach ($balls as $k => $ball) {
            $ballsList[$ball->id] = $ball->name;
        }
        foreach ($buckets as $k => $bucket) {
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
    public function store_ball(Request $req, $id = false)
    {
        $req->validate([
            'name' => 'required',
            'volume' => 'required',
        ]);
        $obj = new Balls();
        if ($id) {
            $obj = Balls::find($id);
        }
        $obj->name = $req->post('name');
        $obj->volume = $req->post('volume');
        $req->session()->flash('status', 'success');
        if ($id) {
            $obj->update();
            $req->session()->flash('msg', "Balls are updated successful!");
        } else {
            $obj->save();
            $req->session()->flash('msg', "Balls are added successful!");
        }
        Buckets::query()->update(['filled_volume' => 0]);
        Test::query()->delete();

        //

        return  redirect("/");
    }

    public function store_bucket(Request $req, $id = false)
    {
        $req->validate([
            'name' => 'required',
            'volume' => 'required',
        ]);
        $obj = new Buckets();
        if ($id) {
            $obj = Buckets::find($id);
        }
        $obj->name = $req->post('name');
        $obj->volume = $req->post('volume');
        $obj->filled_volume = 0;
        $req->session()->flash('status', 'success');
        if ($id) {
            $obj->update();
            $req->session()->flash('msg', "Buckets are updated successful! and all bucket gets emptied");
        } else {
            $obj->save();
            $req->session()->flash('msg', "Buckets are added successful! and all bucket gets emptied");
        }
        $obj = new Buckets();
        $obj->filled_volume = 0;
        $obj->update();
        Test::query()->delete();

        //
        return  redirect("/");
    }
    public function test(Request $req)
    {

        $bucketObj = Buckets::all();
        $numbers_of_ball = $req->post('numbers_of_ball');
        // echo "<pre>";
        if (count($bucketObj) > 0) {

             $balls=[];
             $msg = 'Places ';
            foreach ($bucketObj as $j => $bucket) {
                $remaining = $bucket->volume - $bucket->filled_volume;

                foreach ($numbers_of_ball as $k => $ballArr) {
                    if ($ballArr != 0 && $remaining != 0 && $ballArr !='') {
                        $ball = Balls::find($k);
                        $newTotal = $ballArr * $ball->volume;
                        $bObj = Buckets::find($bucket['id']);
                        $obj = new Test();
                        $obj->buckets_id = $bucket['id'];
                        $obj->balls_id = $k;
                        if ($newTotal <= $remaining) {
                            $obj->numbers_of_ball =  $ballArr;
                            $bObj->filled_volume = $bObj->filled_volume + $newTotal;
                            $remaining = $remaining - $newTotal;
                            $bObj->update();
                            $obj->save();
                            $msg .= " $ball->name  $ballArr and ";
                            $balls[$k] = $ballArr;
                        } else {
                            $noOfBalls = floor($remaining / $ball->volume);
                            if ($noOfBalls != 0) {
                                $obj->numbers_of_ball =  $noOfBalls;
                                $newTotal = $noOfBalls * $ball->volume;
                                $bObj->filled_volume = $bObj->filled_volume + $newTotal;
                                $msg .= "$ball->name  $noOfBalls and";

                                $bObj->update();
                                $obj->save();
                                $balls[$k] = $noOfBalls;
                                $remaining = $remaining - $newTotal;
                            }
                        }
                        $numbers_of_ball[$k] = $numbers_of_ball[$k] - $ballArr;  // removed stored ball in bucket from aray

                    }
                }
            }
            if(count($balls) >0){
                $req->session()->flash('status', 'success');
                $req->session()->flash('msg', $msg." Balls are added in bucket successful!");
            }else{
                $req->session()->flash('status', 'error');
                $req->session()->flash('msg', "No Balls are added in bucket!");
            }
           
        } else {
            $req->session()->flash('status', 'error');
            $req->session()->flash('msg', "Bucket not available Please add buckets");
        }
        return  redirect("/");
    }
}