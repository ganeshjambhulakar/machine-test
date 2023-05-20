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
    <div class="container mt-5 mb-5 d-flex justify-content-center">
        <div class="card px-1 py-4" style="width: 50vw;">
        <div class="d-flex justify-content-end">
         <button class="btn btn-small btn-info mx-1 text-white">  <a href="/" class="text-white"> Dashboard</a></button>
         </div>
        <div class="card-body">
            <h3 class="card-title mb-3 text-center">Edit Bolls</h3>
            <form method="post">
                @CSRF
                <div class="form-group">
                    <label for="exampleInputEmail1">Boll Name</label>
                    <input type="text" name="name" class="form-control" id="name"  placeholder="Enter boll name" value="<?= $ball[0]['name']?>" >
                 </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Boll Volume (In inches)</label>
                    <input type="number" name="volume" class="form-control" id="volume"  step="0.01" placeholder="Enter boll volume" value=<?= $ball[0]['volume']?> >
        </div>
                
                <button type="submit" class="btn btn-warning btn-lg btn-block">Save</button>
             </form>
        </div>
    </div>
           
</div>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
 

</html>
