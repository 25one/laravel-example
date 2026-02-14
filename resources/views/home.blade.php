@extends('layouts.layout')

@section('css')

@endsection

@section('main')

        <!-- Icons Grid-->
        <section class="features-icons bg-light text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex">
                            <!-- <i class="bi-window m-auto text-primary"></i> -->
                            <i class="bi bi-diagram-3 m-auto text-primary"></i> 
                            </div>
                            <h3>Prompt Chains</h3>
                            <p class="lead mb-0">Create prompt chains for your business processes</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex">
                            <!-- <i class="bi-layers m-auto text-primary"></i> -->
                            <i class="bi bi-play-btn m-auto text-primary"></i> 
                            </div>
                            <h3>API access</h3>
                            <p class="lead mb-0">Use API access for execution prompt chains in your application</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                            <div class="features-icons-icon d-flex">
                            <!-- <i class="bi-terminal m-auto text-primary"></i>-->
                             <i class="bi bi-chat m-auto text-primary"></i>
                            </div>
                            <h3>AI chat</h3>
                            <p class="lead mb-0">Enable AI chat for your customers in your application</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Image Showcases-->
        <section class="showcase">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('assets/img/bg-showcase-1-new.jpg')"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>Prompts-Project-Dashboard</h2>
                        <p class="lead mb-0">To automate your business processes, create prompts and combine them into chains (project) (for more information, see Manual and API Settings on the Dashboard page after login/register)</p>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-6 text-white showcase-img" style="background-image: url('assets/img/bg-showcase-2-new.jpg')"></div>
                    <div class="col-lg-6 my-auto showcase-text">
                        <h2>API-access to your prompts</h2>
                        <p class="lead mb-0">Use the API in your project to access your prompts, automating routine tasks (e.g., AI-powered text product description generation) (for more information, see Manual and API Settings on the Dashboard page after login/register)</p>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('assets/img/bg-showcase-3-new.jpg')"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>AI-сhat in your project</h2>
                        <p class="lead mb-0">Connect and use AI-chat on your project pages. It works with your company's information but doesn't require human resources (for more information, see Manual and API Settings on the Dashboard page after login/register)</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonials-->
        <!-- 
        <section class="testimonials text-center bg-light">
            <div class="container">
                <h2 class="mb-5">What people are saying...</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                            <img class="img-fluid rounded-circle mb-3" src="{{ asset('assets/img/testimonials-1.jpg') }}" alt="..." />
                            <h5>Margaret E.</h5>
                            <p class="font-weight-light mb-0">"This is fantastic! Thanks so much guys!"</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                            <img class="img-fluid rounded-circle mb-3" src="{{ asset('assets/img/testimonials-2.jpg') }}" alt="..." />
                            <h5>Fred S.</h5>
                            <p class="font-weight-light mb-0">"Bootstrap is amazing. I've been using it to create lots of super nice landing pages."</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                            <img class="img-fluid rounded-circle mb-3" src="{{ asset('assets/img/testimonials-3.jpg') }}" alt="..." />
                            <h5>Sarah W.</h5>
                            <p class="font-weight-light mb-0">"Thanks so much for making these free resources available to us!"</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        --> 
        <!-- Call to Action-->
        <section class="call-to-action text-white text-center" id="signup">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <h2 class="mb-4">Ready to get started? Sign up now!</h2>
                        <!-- Signup form-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <form class="form-subscribe" id="contactFormFooter" data-sb-form-api-token="API_TOKEN">
                            <!-- Email address input-->
                            <div class="row">
                                <!--
                                <div class="col">
                                    <input class="form-control form-control-lg" id="emailAddressBelow" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddressBelow:required">Email Address is required.</div>
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddressBelow:email">Email Address Email is not valid.</div>
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
        </section>      

@endsection

@section('js')

@endsection
