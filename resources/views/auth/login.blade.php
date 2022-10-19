@extends('layouts._app-guest')

@section('content')
<div class="devloginout"></div>
    <div class="devimagenew"></div>
    <div id="wrapper">
        <div class="loginmain">
            <div class="container">
                <div class="row">
                    <div class="compimg"><img src="{{ asset('theme/img/devlogin_bg.png') }}" class="img-fluid" alt=""/></div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="loginbx devloginbx col-sm-12 col-md-8">
                        <h1>Developer Login</h1>
                        {!! Form::open(['route' => 'login', 'class' => 'dev-login-page-form']) !!}
                            <div class="form-group">
                                {!! Form::text('email',null,['class' => 'form-control','placeholder' => 'Admin Email', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {{ Form::password('password', [ 'class'=>"form-control",'placeholder' => 'Password', 'required']) }}
                            </div>

                            <div class="form-group">
                                <div class="login-validation" >
                                    {!! $errors->first() !!}
                                </div>
                            </div>

                            {!! Form::button('<span class="fas fa-arrow-right"></span>',['class' => 'btn btn-primary loginbtn', 'type' => 'submit']) !!}

                            <div class="form-group mt-3">
                            <a href="{{ route('password.request') }}" class="devforgotbtn">Forgot Password?</a>

                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 dimgcomp"><img src="{{ asset('theme/img/devlogin_bg.png') }}" class="img-fluid" alt=""/></div>
                </div>
            </div>
        </div>
    </div>
@endsection