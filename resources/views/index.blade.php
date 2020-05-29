@extends('layout.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="itemise_inner">
                    <div class="profile_section_inner login_section">
                        <h2>Login to continue</h2>
                        @if(Session::has('reg_success'))
                            <div class="row">
                                <div class="info_alert">{{Session::get('reg_success')}}</div>
                            </div>
                        @endif
                        <form id="loginForm" autocomplete="off">
                            <div class="form-row">
                                <label>Username</label>
                                <input id="username-input" name="username" type="text" class="form-control">
                                <div id="username-field"></div>
                            </div>
                            <div class="form-row">
                                <label>Password</label>
                                <input id="password-input" name="password" type="password" class="form-control">
                                <div id="password-field"></div>
                            </div>
                            <div class="form-row">
                                <button class="form_login_action"> Continue </button>
                            </div>
                        </form>
                        <div class="aleady_note">
                            Don't have an account ? <a href="{{route('register')}}">Create one here</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>

        //to register for new user in register form
        $(document).on('submit',"#loginForm",function (event) {
            event.preventDefault();
            let data = $(this).serialize();
            axios.post("{{route('loginPost')}}", data).then(data =>{
                if(data.data.redirect_link != undefined){
                    window.location = data.data.redirect_link;
                }else{
                    Notiflix.Report.Failure( 'Login fail',data.data.fail , 'Ok' );
                }
            }).catch(error =>{
                printErrorMsg(error.response.data.error);
            });
        });

        //to print error to specific control
        function printErrorMsg(msg) {
            if(msg != undefined){
                var obj = Object.keys(msg);
                processError(msg, obj, 'username', '#username-input','#username-field');
                processError(msg, obj, 'password', '#password-input','#password-field');
            }
        }

        //process error that was call in printErrorMsg function
        function processError(msg, obj, name, input, validation_field) {
            //to check whether key of array is existed or not
            if(jQuery.inArray(name, obj) == '-1'){
                $(input).removeClass('has-error');
                $(validation_field).html('');
            }else{
                $(input).addClass('has-error');
                $(validation_field).html('<div class="error_input">'+ msg[name] +'</div>');
            }
        }
    </script>
@stop
