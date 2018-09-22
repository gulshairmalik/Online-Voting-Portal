@extends('layouts/header')

<div class="login-wrap" style="max-width:800px;">
    
    <h1 class="text-center ">Register</h1>
    <p style="color:white;">We have sent an SMS code to your Mobile#. Please verify it to get Registered.</p>
    <form method="POST" action="index">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="verify" placeholder="Please enter sms code." required>
                    <span class="text-danger">@if($err!="") {{$err}} @endif</span>
                </div>
            </div>
        <div class="row">
                <div class="col-md-6">
                    <button id="submit2" type="submit" class="btn btn-primary">Verify</button>
                </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
@extends('layouts/footer')
