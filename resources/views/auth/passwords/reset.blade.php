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
                        <h1>Reset Password</h1>
                        {!! Form::open(['route' => 'password.request', 'class' => 'dev-login-page-form']) !!}
                            {!! Form::hidden('token', $token ) !!}
                            <div class="form-group">
                                {!! Form::text('email',null,['class' => 'form-control','placeholder' => 'Admin Email', 'required']) !!}
                                <div class="login-validation" >
                                    {!! $errors->first('email') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::password('password', [ 'class'=>"form-control",'placeholder' => 'Password', 'required']) }}
                                <div class="login-validation" >
                                    {!! $errors->first('password') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::password('password_confirmation', [ 'class'=>"form-control",'placeholder' => 'Confirm Password', 'id' => 'password-confirm', 'name' => 'password_confirmation', 'required' ]) }}
                            </div>

                            {!! Form::button('<span class="fas fa-arrow-right"></span>',['class' => 'btn btn-primary loginbtn', 'type' => 'submit']) !!}

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