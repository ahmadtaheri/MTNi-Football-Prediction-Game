<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asia 2024</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
          integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 90px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            z-index: 99;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 11.5rem;
                padding: 0;
            }
        }

        .navbar {
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
        }

        @media (min-width: 767.98px) {
            .navbar {
                top: 0;
                position: sticky;
                z-index: 999;
            }
        }

        .sidebar .nav-link {
            color: #333;
        }

        .sidebar .nav-link.active {
            color: #0d6efd;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<nav class="navbar navbar-light bg-light p-3">
    <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
        <a class="navbar-brand" href="/">
            Asia 2024
        </a>
        <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse"
                data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
        {{--<div class="mr-3 mt-1">--}}
        {{--<a class="github-button" href="https://github.com/themesberg/simple-bootstrap-5-dashboard" data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star /themesberg/simple-bootstrap-5-dashboard">Star</a>--}}
        {{--</div>--}}
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                Hello, {{Auth::user()->firstName}}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                <li><a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Logout
                    </a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
                    {{ csrf_field() }}
                </form>

                {{--<li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>--}}
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        {{--Main Structure--}}
        <main class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <h1 class="h2">Dashboard</h1>
            {{--admin area--}}
            @if (Auth::user()->isAdmin)
                <div class="row  mb-2">
                    <div class="col-lg-8 col-sm-12">
                        <a class="btn btn-success" href="/registerResult">Final Result Register</a>
                        <a class="btn btn-secondary" href="/registerMatch">Match Register</a>
                        <a class="btn btn-danger" href="/registerExcelPoints">Register Excel Points</a>
                    </div>
                </div>
                <div class="row  mb-2">
                    <div class="col-lg-8 col-sm-12">
                        <a class="btn btn-primary" href="/showMatchesForPredictions">Users Predictions</a>
                        <a class="btn btn-info" href="/showSumOfLastMatchesPerUser">Last Matches Points </a>
                        <a class="btn btn-secondary" href="/reportCupWinnerPredictions">Cup winner Predictions </a>
                    </div>
                </div>
                <hr class="bg-success border-top border-success" style="height: 5px">
            @endif

            {{--Message part--}}
            @isset($msg)

                <div class="row">

                    <div class="alert alert-dark" role="alert">
                        {{$msg}}
                    </div>

                </div>
            @endisset

            {{--champion Selection Area--}}
            @isset($championPrediction)
                <div class="row mb-5">
                    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header alert-danger">Your Cup Winner Prediction is
                                @isset(Auth::user()->cupWinner->champion_team)
                                    <span class="text-dark">
                                        {{Auth::user()->cupWinner->champion_team}}
                                    </span>
                                @endisset
                            </h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Cup Winner</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <form class="my-3" method="POST" action="/registerCupWinner">
                                            @csrf
                                            <tr>
                                                <td>
                                                    <select class="form-select col-12 col-md-4"
                                                            aria-label="Default select example"
                                                            name="cupWinner">
                                                        @foreach ($championPrediction as $team)
                                                            <option value="{{$team}}">{{ $team}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    @if (isset(Auth::user()->cupWinner->champion_team))
                                                        <button type="submit" class="btn btn-primary">
                                                            Update Cup Winner
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-primary">
                                                            Predict Cup Winner
                                                        </button>
                                                    @endif
                                                </td>

                                            </tr>

                                        </form>

                                        </tbody>
                                    </table>
                                </div>
                                {{--<a href="#" class="btn btn-block btn-light">View all</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="bg-success border-top border-success" style="height: 5px">
            @endisset

            {{--Matches Predictions area--}}
            @isset($matches)
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        @foreach ($matches as $match)
                            <form class="m-5" method="POST" action="/matchPrediction/{{$match->id}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{$match->teamA}}</label>
                                    <input type="number" class="form-control" id="teamA_Score_prediction"
                                           name="teamA_Score_prediction" aria-describedby="emailHelp" required
                                           value="{{$match->users()->wherePivot('user_id',Auth::id())->value('teamA_Score_prediction')}}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{$match->teamB}}</label>
                                    <input type="number" class="form-control" id="teamB_Score_prediction"
                                           name="teamB_Score_prediction" aria-describedby="emailHelp" required
                                           value="{{$match->users()->wherePivot('user_id',Auth::id())->value('teamB_Score_prediction')}}">
                                </div>

                                <button type="submit" class="btn btn-primary" id="predict">Predict | {{$match->teamA}}
                                    vs {{$match->teamB}} </button>
                            </form>
                            {{--@endif--}}
                        @endforeach
                    </div>
                    <hr class="bg-success border-top border-success" style="height: 5px">
                </div>
            @endisset

            {{--Ranking table--}}
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                    <div class="card">
                        <h5 class="card-header">Ranking Table</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Points</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i=0)
                                    @foreach($ranks as $name =>$point)
                                        <tr>

                                            <th scope="row">{{$i+=1}}</th>
                                            <td>{{$name}}</td>
                                            <td>{{$point}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                </div>
            </div>

            {{--history table--}}
            <div class="row mt-4">
                <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                    <div class="card">
                        <h5 class="card-header alert-danger">Your Prediction History</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Team A</th>
                                        <th scope="col">Team B</th>
                                        <th scope="col">Match Point</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i=0)
                                    @foreach($predictionHistory as $match)
                                        <tr>
                                            <th scope="row">{{$i+=1}}</th>
                                            <td>{{$match->teamA}} : <span
                                                        class="text-primary">{{$match->pivot->teamA_Score_prediction}}</span>
                                            </td>
                                            <td>{{$match->teamB}} : <span
                                                        class="text-primary">{{$match->pivot->teamB_Score_prediction}}</span>
                                            </td>
                                            <td>{{$match->pivot->match_point}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{--<a href="#" class="btn btn-block btn-light">View all</a>--}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                </div>
            </div>

            <footer class="pt-5 d-flex justify-content-between">
                <span>Copyright © 2021 Powered By Ahmad Taheri </span>
                {{--<ul class="nav m-0">--}}
                {{--<li class="nav-item">--}}
                {{--<a class="nav-link text-secondary" aria-current="page" href="#">Privacy Policy</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                {{--<a class="nav-link text-secondary" href="#">Terms and conditions</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                {{--<a class="nav-link text-secondary" href="#">Contact</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
            </footer>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script>
    new Chartist.Line('#traffic-chart', {
        labels: ['January', 'Februrary', 'March', 'April', 'May', 'June'],
        series: [
            [23000, 25000, 19000, 34000, 56000, 64000]
        ]
    }, {
        low: 0,
        showArea: true
    });
</script>

</body>
</html>