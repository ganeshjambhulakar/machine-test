<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
        
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>

    <body class="antialiased">
    <div class="container mt-5 mb-5 d-flex justify-content-center ">
    <?php  if(session('status') == 'success') {   ?>
          <div class=" text-center alert alert-success" role="alert">
           <?= session('msg')  ?>
          </div>
          <?php   } elseif(session('status') == 'error') {?>
            <div class=" text-center alert alert-danger" role="alert">
           <?= session('msg')  ?>
          </div>
          <?php }?>
      </div>
    <div class="container mt-5 mb-5 d-flex justify-content-between  ">
      <div class="card px-1 py-4 mx-1" style="width: 40vw;">
      
         <div class="d-flex justify-content-end">
         <button class="btn btn-small btn-info mx-1 text-white">  <a href="/add_ball" class="text-white"> Add Bolls </a></button>
         <button class="btn btn-small btn-info"> <a href="/add_bucket"  class="text-white"> Add Bucket </a></button>
         </div>
        
        <div class="card-body">
            <h3 class="card-title mb-3 text-center">Test Machine</h3>
            <form action="/savetest" method="POST">
            @CSRF
            <?php
            if(count($balls)<=0){
              ?>
              <div class="row">
                    <div class="col-md-12 text-center">
                    <label>No Balls available,Please add Balls</label>
                    </div>
                    </div>
                  </div>
              <?php
            }
              foreach ($balls as $key=>$ball) { ?>
                  <div class="row">
                    <div class="col-md-2">
                    <label><?php echo $ball['name'];?></label>
                    </div>
                    <div class="col-md-10">
                    <div class="form-group">
                    <input type="number" name="numbers_of_ball[<?= $ball['id'] ?>]" class="form-control" id="name" >
                    </div>  
                    </div>
                  </div>
                  <?php   }   
                  if(count($bucketsList) >=0){
                    ?>
                      <button type="button" disabled  class="btn btn-warning btn-lg btn-block">No Bucket are Available to store balls</button>
                    <?php
                  }else{
                    ?>
                     <button type="submit" class="btn btn-warning btn-lg btn-block">PLACE BALLS IN BUCKET</button>
                    <?php
                  }
                  ?>
             </form>
        </div>
    </div>
    <div class="card px-1 py-4" style="width: 40vw;">
        
        <div class="card-body">
            <h3 class="card-title mb-3 text-center">Result</h3>
            <?php
                $bucketData = [] ;
    foreach($tests as $k=>$test) {
        if(isset($bucketData[$bucketsList[$test->buckets_id]][$ballsList [$test->balls_id]])) {
            $bucketData[$bucketsList[$test->buckets_id]][$ballsList [$test->balls_id]] += $test->numbers_of_ball ;
        } else {
            $bucketData[$bucketsList[$test->buckets_id]][$ballsList[$test->balls_id]] =  $test->numbers_of_ball;
        }
    }
    echo "<ul>";
    foreach($bucketData as $k=>$bucket) {
        echo "<li>  $k : <b> Places ";
        $i =  count($bucket);
        foreach($bucket as $k1=>$buct) {
            echo  " $buct  $k1 Balls " ;
            $i--;
            if($i) {
                echo " and ";
            }

        }
        echo "</b></li>";
    }
    echo "</ul>";
    ?>
            
        </div>
    </div>
</div>
<div class="container d-flex justify-content-between mt-5 mb-5 ">
        <div class="card px-1" style="width: 40vw;">
        <div class="card-body">
            <h3 class="card-title mb-3 text-center">Buckets</h3>
            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Filled Volume</th>
      <th scope="col">Total Volume</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($buckets as $key=>$bucket) { ?>
    <tr>
      <th scope="row"><?= $key+1?></th>
      <td><?= $bucket['name']?></td>
      <td><?= $bucket['filled_volume']?></td>
      <td><?= $bucket['volume']?></td>
      <td><a href="edit_bucket/<?= $key+1?>">Edit</a></td>
    </tr>
     <?php }?>
  </tbody>
</table>
            
        </div>
    </div>
    <div class="card px-1" style="width: 40vw;">
        
        <div class="card-body">
            <h3 class="card-title mb-3 text-center">Balls</h3>
            <table class="table">
   <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Volume</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($balls as $key=>$ball) { ?>

<tr>
<th scope="row"><?= $key+1?></th>
  <td><?= $ball['name']?></td>
  <td><?= $ball['volume']?></td>
  <td><a href="edit_ball/<?= $key+1?>"> Edit</a></td>
</tr>
<?php }?>

  </tbody>
</table>
            
        </div>
    </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
    <script>
    $(document).ready(function(){
        
    })
    // $("#test").submit(function(e){
    //     var ballsArr = ["Pink","Red","Blue","Orange","Green"]
    //     var bucketsArr = ["A","B","C","D","E"]
    //     var bucketVolume = [
    //         1:20,
    //         2:18,
    //         3:12,
    //         4:10,
    //         5:8,

    //     ]
    //     var ballsVolume = [
    //         1:2.5,
    //         2:2,
    //         3:1,
    //         4:0.8,
    //         5:0.5,
    //     ]
    //     e.preventDefault();
    //     var bucket = $("#bucket_id").val();
    //     var ball = $("#ball_id").val();

        
    //     alert(bucket)
    // })

    </script>
</html>
