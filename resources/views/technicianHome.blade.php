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

                

            </div>
            <br>
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{$pending}}</h5>
                    <p class="card-text">Number of pending requisitions</p>
                    <a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingRequisitions') }}">Go to pending requisitions</a>
                    
                </div>
            </div>

        </div>

    </div>

</div>

@endsection