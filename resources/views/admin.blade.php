@extends('layouts/header')

<a href='logout'><button class="btn btn-danger" style='border-radius:25px; float:right'>Log-Out</button></a>


<div class="login-wrap" style="max-width:900px;">
        <h1 style='color:white' class='text-center'>Admin</h1>

        <div class="alert alert-success" style="@if($form_data['style']=='') {{ 'display:none' }} @else {{'display:block'}} @endif"><strong>Election Organized Successfully.</strong></div>
        <div class="row">
            <div class="col-md-4">
                <form action="result" method="post" target="_blank">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type='submit' class="btn btn-success" style="border-radius:25px; @if($form_data['style']=='') {{ 'display:none' }} @else {{'display:block'}} @endif" @if($form_data['result_table']==null) {{'disabled'}} @else {{'enabled'}} @endif>Show Result</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="end" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger" style="border-radius:25px; @if($form_data['style']=='') {{ 'display:none' }} @else {{'display:block'}} @endif" @if($form_data['result_table']!=null) {{'disabled'}} @else {{'enabled'}} @endif>End Election</button>
                </form>
            </div>
            <div class="col-md-4">
                    <form action="organize" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type='submit' class="btn btn-primary" style="border-radius:25px; @if($form_data['style']=='') {{ 'display:none' }} @else {{'display:block'}} @endif" @if($form_data['result_table']==null) {{'disabled'}} @else {{'enabled'}} @endif>Organize New Election</button>
                    </form>
                </div>
        </div>
        <!--SHOW RESULT-->

        <div>

        </div>
    <form id="candidate1" action="admin" method="post" enctype="multipart/form-data" style="{{ $form_data['style'] }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
        <div class="col-md-6">
        <div class="form-group">
          <input type="text" class="form-control" name="name1" placeholder="Name of candidate 1" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="party_name1" placeholder="Name of Party" required>
        </div>
        <div class="form-group ">
            <input type="text" pattern="\d*" maxlength="4" minlength="3" class="form-control" name="nc_no1" placeholder="NC# of candidate 1" required>
        </div>
        <div class="form-group">
                <input id="uploadFile1" style="color:black;" value="Choose File" disabled="disabled" >
                 <div class="fileUpload btn btn-primary">
                     <span>Upload</span>
                     <input id="uploadBtn1" accept="image/x-png,image/gif,image/jpeg"  name="cover_img1" type="file" class="upload" required>
                 </div>
               </div>
        <span class="text-danger"></span>
    </div>
        <!-- candidate 2 form -->
        <div class="col-md-6">
        <div class="form-group">
                <input type="text" class="form-control" name="name2" placeholder="Name of candidate 2" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="party_name2" placeholder="Name of Party" required>
              </div>
              <div class="form-group">
                  <input type="text" pattern="\d*" maxlength="4" minlength="3" class="form-control" name="nc_no2" placeholder="NC# of candidate 2" required>
              </div>
              <div class="form-group">
               <input id="uploadFile" style="color:black;" value="Choose File" disabled="disabled" >
                <div class="fileUpload btn btn-primary">
                    <span>Upload</span>
                    <input id="uploadBtn" accept="image/x-png,image/gif,image/jpeg"  name="cover_img2" type="file" class="upload" required>
                </div>
              </div>
              
              
        </div>
    </div>
    <br>
    <div class="text-center">
        <button id="submit2" type="submit" class="btn btn-primary">Organize Election</button>
    </div>
    </form>

</div>
<script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
        document.getElementById("uploadBtn1").onchange = function () {
            document.getElementById("uploadFile1").value = this.value;
        };
</script>
@extends('layouts/footer')