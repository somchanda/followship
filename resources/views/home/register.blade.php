@extends('layout.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="itemise_inner">
                    <div class="profile_section_inner login_section">
                        <h2>Create an Account</h2>
                        <form id="reqForm">
                            <div class="form-row">
                                <label>Full Name</label>
                                <input type="text" id="name-input" name="name" class="form-control">
                                <div id="name-field"></div>
                            </div>
                            <div class="form-row">
                                <label>Email</label>
                                <input type="text" id="email-input" name="email" class="form-control">
                                <div id="email-field"></div>
                            </div>
                            <div class="form-row">
                                <label>Username</label>
                                <input type="text" id="username-input" name="username" class="form-control">
                                <div id="username-field"></div>
                            </div>
                            <div class="form-row">
                                <label>Password</label>
                                <input type="password" id="password-input" name="password" class="form-control">
                                <div id="password-field"></div>
                            </div>
                            <div class="form-row">
                                <button type="submit" class="form_login_action"> Continue </button>
                            </div>
                        </form>
                        <div class="aleady_note">
                            Already have an account ? <a href="{{route('home')}}">Login Here</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(document).on('submit',"#reqForm",function (event) {
           event.preventDefault();
           loadSpinner('.form_login_action');
           let data = $(this).serialize();
           axios.post("{{route('registerPost')}}", data).then(data =>{
               console.log(data);
               removeLoader('.form_login_action', 'Continue');
           }).catch(error =>{
                printErrorMsg(error.response.data.error);
                removeLoader('.form_login_action', 'Continue');
           });
        });

        //to display loader icon on specific element
        function loadSpinner(item) {
            $(item).html('<div class="loader"></div>');
            $(item).attr('disabled',true);
        }

        //to remove loader icon on specific element
        function removeLoader(item,message) {
            $(item).html(message);
            $(item).attr('disabled',false);
        }

        function printErrorMsg(msg) {
            if(msg != undefined){
                var obj = Object.keys(msg);
               processError(msg, obj, 'name', '#name-input','#name-field');
               processError(msg, obj, 'email', '#email-input','#email-field');
               processError(msg, obj, 'username', '#username-input','#username-field');
               processError(msg, obj, 'password', '#password-input','#password-field');
            }
        }

        function processError(msg, obj, name, input, validation_field) {
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


