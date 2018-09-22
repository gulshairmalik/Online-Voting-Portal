@extends('layouts/header')

<div class="login-wrap" style="max-width:800px;">
    
    <h1 class="text-center ">Register</h1>
    <form id="form2" method="POST" action="">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('cpassword') ? 'has-error' : '' }}">
                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
                    <span class="text-danger">{{ $errors->first('cpassword') }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('nc#') ? 'has-error' : '' }}">
                    <input type="number" class="form-control" name="nc#" placeholder="NC no." value="">
                    <span class="text-danger">{{ $errors->first('nc#') }} @if($nc_err!="") {{$nc_err}} @endif</span>
                </div>
            </div>
        </div>
        
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('cnic') ? 'has-error' : '' }}">
                        <input type="number" class="form-control" name="cnic" placeholder="CNIC# without dashes">
                        <span class="text-danger">{{ $errors->first('cnic') }}</span>
                    </div>
                </div>
            
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('mob#') ? 'has-error' : '' }}">
                        <input type="number" class="form-control" name="mob#" placeholder="Mobile no. (e.g. 923367215150)">
                        <span class="text-danger">{{ $errors->first('mob#') }}</span>
                    </div>
                    
                </div>
            </div>
        
        <div class="row">
                <div class="col-md-6">
                    <button id="submit2" type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="col-md-6">
                    
                </div>
        </div>
    </form>
    <p style="color:whitesmoke;">If you are already registered then Login to cast vote.</p>
    <a href="login"><button id="login" class="btn btn-success">Login</button></a>
</div>

<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
@extends('layouts/footer')
