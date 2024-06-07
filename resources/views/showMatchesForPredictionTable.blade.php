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
            Euro 2021
        </a>
        <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse"
                data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    {{--<div class="col-12 col-md-4 col-lg-2">--}}
    {{--<input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">--}}
    {{--</div>--}}
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
            {{--admin area--}}

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
                                        <th scope="col">Match</th>
                                        <th scope="col">MatchTime</th>
                                        <th scope="col">No. of Predictions</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    @isset($matches)
                                    <tbody>
                                    @php($i=0)
                                    @foreach($matches as $match)
                                        <tr>
                                            <form method="POST" action="/showMatchPredictions/{{$match->id}}">
                                                @csrf
                                            <th scope="row">{{$i+=1}}</th>
                                            <td>{{$match->teamA}}-{{$match->teamB}}</td>
                                            <td>{{$match->matchTime}}</td>
                                            <td>{{$match->users->count()}}</td>
                                            <td><button type="submit" class="btn btn-primary">Show Predictions</button></td>
                                            </form>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    @endisset
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