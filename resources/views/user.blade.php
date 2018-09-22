@extends('layouts/header')

<a href='logout'><button class="btn btn-danger" style='border-radius:25px; float:right'>Log-Out</button></a>

<div class="login-wrap" style="max-width:900px; max-height:500px;">
    <h1 style='color:white' class='text-center'>Voting Portal</h1>

    <div class="alert alert-success" style="@if($data['style']=='') {{ 'display:block' }} @else {{'display:none'}} @endif"><strong>Elections have not yet been organized.</strong></div>
    <div style="@if($data['style']=='') {{ 'display:none' }} @else {{'display:block'}} @endif">
        <div class="row" style="">
            <div class="col-md-6">
                <form id="candidate1" action="user" method="post" enctype="multipart/form-data" style="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <img class="img img-responsive" style="border-radius:25px;" src="../public/storage/cover_images/{{$data['cover_img1']}}">
                    <div>
                            <label style="color:white">Candidate Name: {{$data['name1']}}</label><br>
                            <label style="color:white">Party Name: {{$data['party_name1']}}</label>
                            <input type="text" class="form-control" value="{{$data['nc_no_user']}}" name="nc_no_user" readonly>
                            <input type="hidden" name="user" value="1">
                            <br>
                    </div>
                    <div class="col-xs-offset-3">
                            
                        <button id="submit1" style="width:60%;" type="submit" class="btn btn-success" {{$data['btn']}}>Vote</button>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <form id="candidate2" action="user" method="post" enctype="multipart/form-data" style="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <img class="img img-responsive" style="border-radius:25px;" src="../public/storage/cover_images/{{$data['cover_img2']}}">
                    <div>
                            <label style="color:white">Candidate Name: {{$data['name2']}}</label><br>
                            <label style="color:white">Party Name: {{$data['party_name2']}}</label>
                            <input type="text" class="form-control" name="nc_no_user" value="{{$data['nc_no_user']}}" readonly>
                            <input type="hidden" name="user" value="2">
                            <br>
                    </div>
                    <div class="col-xs-offset-3">   
                        <button id="submit2" style="width:60%;" type="submit" class="btn btn-success" {{$data['btn']}}>Vote</button>
                    </div>
                </form>
            </div>
        </div>
        <div class = 'alert alert-danger' style="{{$data['vote_style']}}">
            You have already casted your vote.
        </div>
    </div>

</div>

@extends('layouts/footer')