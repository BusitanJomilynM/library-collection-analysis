@extends('master_layout.master')
@section('Title', 'Home')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Welcome, technician librarian {{$user->first_name}} {{$user->last_name}}. 
                </div>
              
                <div class="float-container">
                    <div class="float-child">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{$pending}}</h5>
                                <p class="card-text">Pending requisitions</p>
                                <a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingRequisitions') }}">Go to pending requisitions</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="float-child">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{$pendingsubject}}</h5>
                                <p class="card-text">Pending subject requests</p>
                                <a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingTags') }}">Go to pending subject requests</a>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.float-container {
    border: 3px solid #fff;
    padding: 20px;
}

.float-child {
    width: 50%;
    float: left;
    padding: 20px;
   
}
</style>

@endsection