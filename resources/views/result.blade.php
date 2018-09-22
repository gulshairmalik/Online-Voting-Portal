@extends('layouts/header')

<div class="login-wrap" style="max-width:900px;">
            <h1 style='color:white' class='text-center'>Results</h1>
    <div class="">
            <div class="row" style='color:white;'>

        <div class="col-md-6">
            <h2>Candidate Name: {{$data['name1']}}</h2>
            <h2>Party Name: {{$data['party1']}}</h2>
            <h2>Number of Votes: {{$data['vote1']}}</h2>

        </div>
        <div class="col-md-6">
            <h2>Candidate Name: {{$data['name2']}}</h2>
            <h2>Party Name: {{$data['party2']}}</h2>
            <h2>Number of Votes: {{$data['vote2']}}</h2>

        </div>

        </div>
    </div>
</div>

@extends('layouts/footer')