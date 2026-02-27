<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>AI-CRM Pilot - нow businesses can use AI models in their daily work --- как бизнесу использовать AI-модели в своей повседневной практике</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <!-- bi bi -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
        <!-- zmdi zmdi -->
        <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />     
        @yield('css')
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="/">AI-CRM Pilot</a>
                <div class="text-right">

                    <!--
                    <a class="btn btn-primary" href="{{route('register')}}">Sign Up</a>
                    <a class="btn btn-success" href="{{route('login')}}">Sign In</a>
                    -->

                    <!-- <ul class="navbar-nav ms-auto">  -->
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('register'))
                                <!-- <li class="nav-item"> -->
                                    <a class="btn btn-primary" href="{{route('register')}}">Sign Up</a>
                                <!-- </li> -->
                            @endif

                            @if (Route::has('login'))
                                <!-- <li class="nav-item"> -->
                                    <a class="btn btn-success" href="{{route('login')}}">Sign In</a>
                                <!-- </li> -->
                            @endif
                        @else
                            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                                <div class="container">                            
                                    <ul class="navbar-nav ms-auto">
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                {{-- @verified --}}
                                                <a class="dropdown-item" href="{{ route('list-projects') }}">
                                                    <strong @verified class="text-success" @else class="text-primary" @endverified>Dashboard</strong>
                                                </a>
                                                {{-- @endverified --}}
                                                <a class="dropdown-item user-profile" href="#">
                                                </a> 
                                                @admin
                                                <a class="dropdown-item" href="{{ route('settings') }}">
                                                    System settings
                                                </a>  
                                                @endadmin                                                                                          
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
                                    </ul>
                                </div>
                            </nav>

                            {{--
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="content">
                                            <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <b class="caret"></b>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="account-dropdown__body">
                                                @if (auth()->user()->role === 'admin')
                                                <div class="account-dropdown__item">
                                                    <a href="{{route('settings')}}">
                                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                                </div>
                                                @endif
                                                <!--
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div>
                                                -->
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <!-- <a href="#">
                                                    <i class="zmdi zmdi-power"></i>Logout</a> -->

                                                <a href="#" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"><i class="zmdi zmdi-power"></i> Logout</a>
                                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            --}}

                        @endguest
                    <!-- </ul> -->
                </div>
            </div>
        </nav>

      @auth  
      @if (session('notEmailVerified'))
          <div class="alert alert-danger" role="alert">
              {{ session('notEmailVerified') }} <a href="{{route('linkemailverification', [true])}}">send link to your email again</a>
          </div>
      @endif

      @if (session('verifiedRequiredEmail'))
          <div class="alert alert-success" role="alert">
              {{ session('verifiedRequiredEmail') }}
          </div>
      @endif 

      @if (session('verifiedRequiredNotEmail'))
          <div class="alert alert-danger" role="alert">
              {{ session('verifiedRequiredNotEmail') }}
          </div>
      @endif       

      @verified
      @if (! count(auth()->user()->keysActive))
      @if (! auth()->user()->demo_count)
          <div class="alert alert-danger" role="alert">
              You have run out of demo requests. Add api_key to your profile to access the model.
          </div>      
      @endif
      @endif
      @endverified
      @endauth

        <!-- Masthead-->
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <!-- Page heading-->
                            <h1 class="mb-5">Start to use AI models in your business</h1>
                            <!-- Signup form-->
                            <!-- * * * * * * * * * * * * * * *-->
                            <!-- * * SB Forms Contact Form * *-->
                            <!-- * * * * * * * * * * * * * * *-->
                            <!-- This form is pre-integrated with SB Forms.-->
                            <!-- To make this form functional, sign up at-->
                            <!-- https://startbootstrap.com/solution/contact-forms-->
                            <!-- to get an API token!-->
                            <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN">
                                <!-- Email address input-->
                                <div class="row">
                                    <!--
                                    <div class="col">
                                        <input class="form-control form-control-lg" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                                        <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:required">Email Address is required.</div>
                                        <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:email">Email Address Email is not valid.</div>
                                    </div>
                                    <div class="col-auto"><button class="btn btn-primary btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                                    -->
                                    <div class="col text-center"><a class="btn btn-primary btn-lg" href="{{route('register')}}">Sign Up</a></div>
                                </div>
                                <!-- Submit success message-->
                                <!---->
                                <!-- This is what your users will see when the form-->
                                <!-- has successfully submitted-->
                                <div class="d-none" id="submitSuccessMessage">
                                    <div class="text-center mb-3">
                                        <div class="fw-bolder">Form submission successful!</div>
                                        <p>To activate this form, sign up at</p>
                                        <a class="text-white" href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                    </div>
                                </div>
                                <!-- Submit error message-->
                                <!---->
                                <!-- This is what your users will see when there is-->
                                <!-- an error submitting the form-->
                                <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>  

        @yield('main')

        <!-- Footer-->
        <footer class="footer bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                        <!--
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><a href="#!">About</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Contact</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Terms of Use</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Privacy Policy</a></li>
                        </ul>
                        -->
                        <p>&copy; {{ now()->year }} <a target="_blank" href="https://fullstack.25one.com.ua/experiences">Full-Stack school</a> by Oleksandr Koskin. All rights reserved. <br>Developed with <i class="bi bi-heart-fill"></i> in <i class="fab fa-laravel"></i>Laravel and React<br>Contact me +380681072861 (<i class="bi bi-telegram"></i>)</p>
                        <!-- <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2023. All Rights Reserved.</p> -->
                    </div>
                    <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <!--
                            <li class="list-inline-item me-4">
                                <a target="_blank" href="https://www.facebook.com/OleksandrKoskin"><i class="bi-facebook fs-3"></i></a>
                            </li>
                            -->
                            <li class="list-inline-item me-4">
                                <a target="_blank" href="https://www.linkedin.com/in/alexander-koskin-100169"><i class="bi bi-linkedin fs-3"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a target="_blank" href="https://www.youtube.com/channel/UCtOvglhwrJMbSyL1cFLBm0A?view_as=subscriber"><i class="bi bi-youtube fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> -->

        @auth
        <script src="{{ mix('js/profile.js') }}"></script>
        @endauth

        @yield('js')
    </body>
</html>
