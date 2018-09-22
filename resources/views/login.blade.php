@extends('layouts/header')


            <div class="login-wrap" style="max-width:455px;">
                <h1 class="text-center ">Login</h1>
                <form id="form1" action="login" method="post">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                      <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <span class="text-danger">@if($err!="") {{$err}} @endif</span>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="submit1" type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                </div>
                </form> 
                <p style="color:whitesmoke;">If you are not registered, Please register first.</p>
                <a href="register"><button id="reg" class="btn btn-success">Register</button></a>
                
                

            </div>

@extends('layouts/footer')
