@extends('layouts.docs.main')

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h3 class="page-title">Login/Token generation</h3>
        <h4 class="page-title">
            Login to get Access token. <br><br>
            Endpoint: <code>/api/auth/login</code>
        </h4>
        <div class="row">
            <div class="col-md-12">
                Welcome to boilerplate docs
            </div>
        </div>
        <!--Success Response row -->
        <div class="row">
            <div class="col-md-12">
                <!-- TABLE HOVER -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="label label-success">Success Response</span>
                        </h3>
                    </div>
                    <div class="panel-body">
<pre>{
"data": {
    "access_token": "eyJ0eXA...",
    "token_type": "Bearer",
    "token_expiration": "2021-03-17 16:29:51",
    "user": {
            "id": "1",
            "name": "My fullname",
            "avatar": "/storage/avatars/profile.png"
            
        },
    }
}</pre>
                    </div>
                </div>
                <!-- END TABLE HOVER -->
            </div>
        </div>
    </div>
</div>
@endsection