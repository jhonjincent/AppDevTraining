@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<div class="container bootstrap snippet">
  <div class="row">
    <div class="col-lg-2 col-sm-6">
      <div class="circle-tile ">
        <div class="circle-tile-heading dark-blue"><i class="fa fa-users fa-fw fa-3x"></i></div>
        <div class="circle-tile-content dark-blue">
          <div class="circle-tile-description text-faded">Users</div>
          <div class="circle-tile-number text-faded "><span>{{ \App\User::all()->count() }}</span></div>
          <a class="circle-tile-footer" href="{{ route('users') }}">More Info<i class="fa fa-chevron-circle-right"></i></a>
        </div>
      </div>
    </div>
     
    <div class="col-lg-2 col-sm-6">
      <div class="circle-tile ">
        <div class="circle-tile-heading red"><i class="fa fa-folder fa-fw fa-3x"></i></div>
        <div class="circle-tile-content red">
          <div class="circle-tile-description text-faded"> Reports </div>
          <div class="circle-tile-number text-faded "><span>{{ \App\Report::all()->count() }}</span></div>
          <a class="circle-tile-footer" href="{{ route('reports') }}">More Info<i class="fa fa-chevron-circle-right"></i></a>
        </div>
      </div>
    </div> 

    <div class="col-lg-2 col-sm-6">
      <div class="circle-tile ">
        <div class="circle-tile-heading green"><i class="fa fa-stack-overflow fa-fw fa-3x"></i></div>
        <div class="circle-tile-content green">
          <div class="circle-tile-description text-faded"> Departments </div>
          <div class="circle-tile-number text-faded "><span>{{ \App\Department::all()->count() }}</span></div>
          <a class="circle-tile-footer" href="{{ route('departments') }}">More Info<i class="fa fa-chevron-circle-right"></i></a>
        </div>
      </div>
    </div> 

    <div class="col-lg-2 col-sm-6">
      <div class="circle-tile ">
        <div class="circle-tile-heading blue"><i class="fa fa-building-o fa-fw fa-3x"></i></div>
        <div class="circle-tile-content blue">
          <div class="circle-tile-description text-faded"> Companies </div>
          <div class="circle-tile-number text-faded "><span>{{ \App\Company::all()->count() }}</span></div>
          <a class="circle-tile-footer" href="{{ route('companies') }}">More Info<i class="fa fa-chevron-circle-right"></i></a>
        </div>
      </div>
    </div> 
  </div> 
</div>  
  
</div>
</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>

<style>

.circle-tile {
    margin-bottom: 15px;
    text-align: center;
}
.circle-tile-heading {
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 100%;
    color: #FFFFFF;
    height: 80px;
    margin: 0 auto -40px;
    position: relative;
    transition: all 0.3s ease-in-out 0s;
    width: 80px;
}
.circle-tile-heading .fa {
    line-height: 80px;
}
.circle-tile-content {
    padding-top: 50px;
}
.circle-tile-number {
    font-size: 26px;
    font-weight: 700;
    line-height: 1;
    padding: 5px 0 15px;
}
.circle-tile-description {
    text-transform: uppercase;
}
.circle-tile-footer {
    background-color: rgba(0, 0, 0, 0.1);
    color: rgba(255, 255, 255, 0.5);
    display: block;
    padding: 5px;
    transition: all 0.3s ease-in-out 0s;
}
.circle-tile-footer:hover {
    background-color: rgba(0, 0, 0, 0.2);
    color: rgba(255, 255, 255, 0.5);
    text-decoration: none;
}
.circle-tile-heading.dark-blue:hover {
    background-color: #2E4154;
}
.circle-tile-heading.green:hover {
    background-color: #138F77;
}
.circle-tile-heading.orange:hover {
    background-color: #DA8C10;
}
.circle-tile-heading.blue:hover {
    background-color: #2473A6;
}
.circle-tile-heading.red:hover {
    background-color: #CF4435;
}
.circle-tile-heading.purple:hover {
    background-color: #7F3D9B;
}
.tile-img {
    text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.9);
}

.dark-blue {
    background-color: #34495E;
}
.green {
    background-color: #16A085;
}
.blue {
    background-color: #2980B9;
}
.orange {
    background-color: #F39C12;
}
.red {
    background-color: #E74C3C;
}
.purple {
    background-color: #8E44AD;
}
.dark-gray {
    background-color: #7F8C8D;
}
.gray {
    background-color: #95A5A6;
}
.light-gray {
    background-color: #BDC3C7;
}
.yellow {
    background-color: #F1C40F;
}
.text-dark-blue {
    color: #34495E;
}
.text-green {
    color: #16A085;
}
.text-blue {
    color: #2980B9;
}
.text-orange {
    color: #F39C12;
}
.text-red {
    color: #E74C3C;
}
.text-purple {
    color: #8E44AD;
}
.text-faded {
    color: rgba(255, 255, 255, 0.7);
}

</style>


@endsection
