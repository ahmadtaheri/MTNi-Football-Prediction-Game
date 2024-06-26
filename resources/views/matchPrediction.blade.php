<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">

        </div>
        <div class="col">
            @foreach ($matches as $match)
            <form method="POST" action="/matchPrediction/{{$match->id}}">
                @csrf

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">{{$match->teamA}}</label>
                        <input type="number" min="0" max="20" class="form-control" id="exampleInputEmail1" name="teamA_Score_prediction" aria-describedby="emailHelp" >
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">{{$match->teamB}}</label>
                        <input type="number" min="0" max="20" class="form-control" id="exampleInputEmail1" name="teamB_Score_prediction" aria-describedby="emailHelp">
                    </div>



                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            @endforeach

        </div>
        <div class="col">

        </div>
    </div>
</div>


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="jquery-3.5.1.min.js"></script>

</body>
</html>