@extends('front.layout.app') ;

@section('main_content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $global_page_data->reset_password_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <form action="{{ route('customer_reset_password_submit') }}" method="post">
                    @csrf
                    <div class="login-form">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">
                        <div class="mb-3">
                            <label for="" class="form-label">Set New Password</label>
                            <input type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                            <label for="" class="form-label">Retype New Password</label>
                            <input type="password" class="form-control" name="retype_password">
                            @if ($errors->has('retype_password'))
                                <span class="text-danger">{{ $errors->first('retype_password') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary bg-website">Submit</button>
                             
                        </div>
                     </div>
                </form>    
            </div>
        </div>
    </div>
</div>
@endsection