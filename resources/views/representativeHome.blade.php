@extends('master_layout.master')
@section('Title', 'Home')
@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">{{ __('Dashboard') }}</div>

  

                <div class="card-body">

                Welcome, Department Representative {{$user->first_name}} {{$user->last_name}}. 

                </div> 

            </div>
            <br>
            

            <br>
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                <a class="btn btn-primary" href="{{ route('requisitions.create') }}">Add New Requisition</a>
                    
                </div>
            </div>
        </div>

    </div>

</div>

@endsection