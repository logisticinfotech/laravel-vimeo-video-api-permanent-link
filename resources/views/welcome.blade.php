<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Vimeo - Get permanent Link demo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .justify-content-center{
                margin:0 auto;
                text-align: center;
            }
            .custom-upload-file {
                border: 2px solid #4d6df5;
                border-radius: 5px;
                padding: 50px;
                margin-top: 10px;
                max-width: 580px;
                min-width: 580px;
            }
            .file-input-control {
                padding: 10px;
                border: 1px solid #d2d2d2;
                border-radius: 5px;
            }
            .file-button-section {
                padding: 10px;
                margin: 20px 10px -10px 10px;
            }
            .file-button-class {
                padding: 15px 40px;
                color: #fff;
                text-align: center;
                font-size: 14px;
                background: #4d6df5;
                border-radius: 6px;
            }
            .message-section{
                margin: 10px;
            }
            .custom-file-error-msg {
                color: #ff0000;
                font-weight: 600;
            }
            .custom-file-success-msg {
                color: #2fc712;
                font-weight: 600;
            }
            .link_div {
                color: #0e07f3;
                text-decoration-line: underline;
            }
            #link_detail {
                color: #30c5c1;
                font-weight: 600;               
                padding: 4px 13px 4px 10px;
                text-decoration-line: underline;
                word-break: break-word;
            }
            .text_center{
                text-align: center;
                font-weight: 700;
                font-size: 20px;
            }
            .disabled {
                opacity: 0;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="container custom-upload-file">
                <h3 class="text_center">Vimeo get permenant video link</h3>
                <div class="row justify-content-center">
                    <h4>Upload your video file here</h4>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <form class="form-horizontal" name="file_upload_form" method="POST" action="{{ url('video-upload') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <input class="form-control file-input-control" type="file" name="video" id="video" required>
                                    </div>
                                    <div class="form-group row file-button-section">
                                        <button class="btn btn-default file-button-class" type="submit">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="message-section">
                            @if(\Session::has('error'))
                                <label class="custom-file-error-msg">{!! \Session::get('error') !!}</label>
                            @endif
                            @if(\Session::has('success'))
                                <label class="custom-file-success-msg">{!! \Session::get('success') !!}</label>
                                <br />
                                @php
                                    $videoId = session()->get("id");
                                @endphp
                                <a onClick="javascript:void(0)" class="link_div">Get your video's permanent link here</a>
                            @endif
                        </div>
                        <a target="_blank" id="link_detail" class="disabled"></label>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {              
                $(document).on('click','.link_div', function(e){
                    jQuery.ajax({
                        url: "{{ url('get-video-link').'/' . Session::get('id')}}",
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            $("#link_detail").text(result.link);
                            $("#link_detail").attr('href',result.link);
                            $("#link_detail").removeClass('disabled');
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    </body>    
</html>
