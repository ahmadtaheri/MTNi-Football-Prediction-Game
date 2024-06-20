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
    <form class="my-3" method="POST" action="/registerMatch">
        @csrf

        {{--Team selection--}}
    <div class="row">
        <div class="col-3"></div>
        <div class="col-3">
            <label for="">Team A</label>
            <select class="form-select" aria-label="Default select example" name="teamA">
                @isset($teams)
                @foreach ($teams as $team)
                    <option value="{{$team}}">{{ $team}}</option>
                @endforeach
                @endisset
            </select>
        </div>
        <div class="col-3">
            <label for="">Team B</label>
            <select class="form-select" aria-label="Default select example" name="teamB">
                @isset($teams)
                    @foreach ($teams as $team)
                        <option value="{{$team}}">{{ $team}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
        <div class="col-3"></div>
    </div>
        <div class="border-top my-3"></div>

        {{--Date Selection--}}
    <div class="row">
        <div class="col-3"></div>
        <div class="col">
            <label for="">Year</label>
            <select class="form-select" aria-label="Default select example" name="year">
                <option value="1403" selected>1403</option>
            </select>
        </div>
        <div class="col">
            <label for="">Month</label>
            <select class="form-select" aria-label="Default select example" name="month">
                <option value="01">1</option>
                <option value="02">2</option>
                <option value="03" >3</option>
                <option value="04" selected>4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10" >10</option>
                <option value="11" >11</option>
                <option value="12">12</option>
            </select >
        </div>
        <div class="col">
            <label for="">Day</label>
            <select class="form-select" aria-label="Default select example" name="day">
                <option value="01" selected>1</option>
                <option value="02">2</option>
                <option value="03">3</option>
                <option value="04">4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21" >21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>

            </select>
        </div>
        <div class="col-3"></div>
    </div>
        <div class="border-top my-3"></div>

        {{--Time Selection--}}
    <div class="row">
        <div class="col-3"></div>
            <div class="col">
                <label for="">Hour</label>
                <select class="form-select" aria-label="Default select example" name="hour">
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16" >16</option>
                    <option value="17">17</option>
                    <option value="18" selected>18</option>
                    <option value="19">19</option>
                    <option value="20" >20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                </select>
            </div>
            <div class="col">
                <label for="">minutes</label>
                <select class="form-select" aria-label="Default select example" name="minute">
                    <option value="00" selected>00</option>
                    <option value="15">15</option>
                    <option value="30" >30</option>
                    <option value="45">45</option>
                </select>
            </div>
        <div class="col-3"></div>
    </div>
        <div class="border-top my-3"></div>

        {{--Submission--}}
    <div class="row">
            <div class="col-3"></div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-3"></div>
        </div>

     </form>
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