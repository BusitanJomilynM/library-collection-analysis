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

                <div class="float-container">
                    <div class="float-child">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                            <a class="btn btn-primary" href="{{ route('requisitions.create') }}">Create New Requisition</a>   
                            </div>
                        </div>
                    </div>
                    <div class="float-child">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                                <a class="btn btn-primary" href="{{ route('tags.create') }}">Create Subject Request</a>   
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