<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>@yield('Title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">

    <title>{{ config('app.name', 'Library Collection System') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.6.1/lux/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.6.1/lux/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    
    <style>
        
.navbar-custom {
	background-color: red;
}
.navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: white;
        }
        body {
  /* background-image: url('/images/bg.png'); */
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  background-attachment: fixed;
}

.required::after {
        content: ' *';
        color: red;
      }

.modal-dialog {
        max-width: 80%;
        margin: 1.75rem auto;
}
</style>
    

</head>
<body class="container-fluid">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            <img src="{{url('/images/logo.png')}}" alt="Image" width="60" height="60"/><a class="navbar-brand"> 
              Library Collection System
          </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                
                        @if(Auth::user()->type == 'technician librarian' )
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('technician.home')}}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('users.index')}}">Users</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Books
                             </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('books.index')}}">Books</a>
                                    </a>

                                    <a class="dropdown-item" href="{{ route('archive') }}">Archived Books</a>
                                    </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Requisitions
                             </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('requisitions.index')}}">Material Requisitions</a>
                                    </a>

                                    <a class="dropdown-item" href="{{ route('pendingRequisitions') }}">Pending Material Requisitions</a>
                                    </a>
                                </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Suggestions
                             </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('tags.index')}}">Subject Suggestions</a>
                                    </a>

                                    <a class="dropdown-item" href="{{route('keywordsuggest.index')}}">Book Subject Suggestions</a>
                                    </a>
                                </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('keywords.index')}}">Book Subject</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('booklist_pdf')}}">Reports</a>
                        </li>

                      

                        <!-- Staff Librarian Navbar -->
                        @elseif(Auth::user()->type == 'staff librarian')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('staff.home')}}">Home</a>
                            <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Books
                             </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('books.index')}}">Books</a>
                                    </a>

                                    <a class="dropdown-item" href="{{ route('archive') }}">Archived Books</a>
                                    </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Requisitions
                             </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('requisitions.index')}}">Material Requisitions</a>
                                    </a>

                                    <a class="dropdown-item" href="{{ route('pendingRequisitions') }}">Pending Material Requisitions</a>
                                    </a>
                                </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Suggestions
                             </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('tags.index')}}">Subject Suggestions</a>
                                    </a>

                                    <a class="dropdown-item" href="{{route('keywordsuggest.index')}}">Book Subject Suggestions</a>
                                    </a>
                                </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('keywords.index')}}">Book Subject</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('tags.index')}}">Reports</a>
                        </li>

                        <!-- department rep -->
                        @elseif(Auth::user()->type == 'department representative')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('representative.home')}}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('books.index')}}">Books</a>
                        </li>  
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('requisitions.index')}}">Requisitions</a>
                        </li> 
                        
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Suggestions
                             </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('tags.index')}}">Subject Suggestions</a>
                                    </a>

                                    <a class="dropdown-item" href="{{route('keywordsuggest.index')}}">Book Subject Suggestions</a>
                                    </a>
                                </div>
                        </li> 

                        <!-- teacher -->
                        @elseif(Auth::user()->type == 'teacher')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('teacher.home')}}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('books.index')}}">Books</a>
                        </li>  

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Suggestions
                             </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('tags.index')}}">Subject Suggestions</a>
                                    </a>

                                    <a class="dropdown-item" href="{{route('keywordsuggest.index')}}">Book Subject Suggestions</a>
                                    </a>
                                </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('requisitions.index')}}">Requisitions</a>
                        </li> 
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('subjects.index')}}">Subjects</a>
                        </li>  

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('courses.index')}}">Course</a>
                        </li>  

                        

                        @else 
                        
                       
                        @endif 
                    </ul>
            
                
               
                     
                    <ul class="navbar-nav ms-auto">
                    
                   
                        <!-- Authentication Links -->
                        @guest
                        
                        @else
                        <span class="navbar-text">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                                </a>
                                

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                
                                <a class="dropdown-item" href="{{route('editAccount', Auth::user()->id)}}">Edit Account</a>
                                </a>

                                <!-- <a data-toggle="modal" class="dropdown-item" data-target="#editAccountModal" data-action="{{ route('editAccount', Auth::user()->id)}}">Edit Account</a>
                                <a data-toggle="modal" class="dropdown-item" data-target="#editPasswordModal" data-action="{{route('changePassword', Auth::user()->id)}}">Change Password</a> -->

                                <a class="dropdown-item" href="{{route('changePassword', Auth::user()->id)}}">Change Password</a>
                                </a>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    

                                    
                                </div>

                                
                            </li>
</span>
                        @endguest

                    </ul>
                  
                </div>
            </div>
        </nav>
        <br>
        <main class="container-fluid">
            @yield('content')

        </main>
        <div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>
