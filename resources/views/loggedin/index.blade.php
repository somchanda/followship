@extends('layout.main')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="itemise_inner">
                <a href="{{route('logout')}}" class="logout_action"><i class="fas fa-power-off"></i> logout</a>
                <div class="profile_section_inner" style="padding-top: 40px;">
                    <div class="user_profile_image" style="background-image: url({{asset('assets/img/users/'.Auth::user()->avatar)}});
                                width: 100px;
                                height: 100px;
                                background-position: center;
                                background-size: contain;
                                border-radius: 100%;
                                border: 2px solid #f4f4f4;
                                margin: 0 auto;
                                margin-bottom: 30px; position: relative; overflow: hidden">
                        <div id="delete_profile_icon">
                            <span class="delete_img_icon my_delete_icon1"></span>
                            <span class="delete_img_icon my_delete_icon2"></span>
                        </div>
                        <input type="file" name="txt_img" class="upload_btn" id="txt_img">
                        <div class="overlay-layer">Upload</div>
                    </div>

                    <div class="user_profile_name text-center">
                        <h2>{{Auth::user()->name}}</h2>
                    </div>
                </div>
                <div class="profile_info_section">
                    <section class="container py-4">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="tabs" class="nav nav-tabs nav-justified">
                                    <li class="nav-item"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase  active">Profile</a></li>
                                    <li class="nav-item"><a href="" data-target="#followers" data-toggle="tab" class="nav-link small text-uppercase">Followers</a></li>
                                    <li class="nav-item"><a href="" data-target="#following" data-toggle="tab" class="nav-link small text-uppercase">Following</a></li>
                                    <li class="nav-item"><a href="" data-target="#people" data-toggle="tab" class="nav-link small text-uppercase">People ( {{$user->count()}} )</a></li>
                                </ul>
                                <br>
                                <div id="tabsContent" class="tab-content">
                                    <input type="hidden" id="notification" value="{{$notification->count()}}">
                                    @include('home.partials.dashboard',compact('followers','following','notification','user'))
                                    @include('home.partials.follower', compact('followers'))
                                    @include('home.partials.following', compact('following'))
                                    @include('home.partials.people', compact('user'))
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script>
        /*
        to prevent reload page when user click submit form
        */
        $(document).on('submit','#userSearchForm',function (event) {
            event.preventDefault();
        });
        /*
        to handle search function
         */
        $(document).on('keyup','#userSearchForm',function (event) {
            event.preventDefault();
            let data = $('#userSearchInput').val();
            axios.get("{{route('search')}}", {
                params:{
                    term: data
                }
            }).then( data =>  {
                $('#searchResult').html(data.data);
                console.log(data);
            }).catch(error => {
                console.log(error);
            })
        });


        /*
        handle action when user click unfollow, follow, unfollowing
         */
        function processData(user_id, action) {
            let user_action = '';
            if(action == 'unfollow'){
                user_action = 'Are you sure you want to stop this user form following you?'
            }else if(action == 'unfollowing'){
                user_action = 'Are you sure you want to stop follow this user?';
            }
            Notiflix.Confirm.Show('Attention', user_action, 'Yes', 'No',
                function(){ // Yes button callback
                    axios.get('{{route('userAction')}}',{
                        params: {
                            action:action,
                            user_id:user_id
                        }
                    }).then(data => {
                       if(action == 'unfollow'){
                           $('#follower-show-action').html(data.data);
                       }else{
                           $('#following-show-action').html(data.data);
                       }
                        reloadPeople();
                        reloadDashboard();
                    }).catch(error => {

                    });
                },
                function(){ // No button callback

                }
            );
        }
        /*
        To reload people when have some change
         */
        function reloadPeople() {
            axios.get('{{route('userAction')}}',{
                params: {
                    action:'reload-people'
                }
            }).then(data => {
                $('#searchResult').html(data.data);
            }).catch(error => {

            });
        }

        /*
        check whether have new notification or not if have this function will alert to user with notification sound
         */
        function checkNotification() {
            let status = false;
            let notification = $('#notification').val();
            setInterval(function () {
                axios.get('{{route('checkNotification')}}',{
                    params:{
                        count: notification,
                    }
                }).then(data => {
                   if(data.data.data > notification){
                       $('#notification').val(data.data.data);
                        if(status == false){
                            let song = new Audio();
                            song.src = '{{asset('assets/file/just-saying.mp3')}}';
                            song.play();
                            status = true;
                            reloadFollower();
                            reloadDashboard();
                            reloadPeople();
                        }
                   }

                }).catch(error => {

                });
            }, 4000);
        }
        checkNotification();

        /*
        reload follower when have other user follow us
         */
        function reloadFollower() {
            axios.get('{{route('reloadFollower')}}').then(data =>{
                $('#follower-show-action').html(data.data);
            }).catch(error =>{

            });
        }
        function reloadDashboard() {
            axios.get('{{route('reloadDashboard')}}').then(data =>{
                $('#dashboard-show-action').html(data.data);
            }).catch(error =>{

            });
        }

        $(document).on('change', '#txt_img', function(){
            var name = document.getElementById("txt_img").files[0].name;
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File");
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("txt_img").files[0]);
            var f = document.getElementById("txt_img").files[0];
            var fsize = f.size||f.fileSize;
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
            }
            else
            {
                form_data.append("txt_img", document.getElementById('txt_img').files[0]);
                axios.post('{{route('uploadProfile')}}',form_data).then(data =>{
                    var url =  data.data.url;
                    $('.user_profile_image').css('backgroundImage','url("'+ url +'")');
                }).catch(error =>{

                });
                {{--$.ajax({--}}
                {{--    url:"{{route('uploadProfile')}}",--}}
                {{--    method:"POST",--}}
                {{--    data: form_data,--}}
                {{--    contentType: false,--}}
                {{--    cache: false,--}}
                {{--    processData: false,--}}
                {{--    beforeSend:function(){--}}
                {{--        //$('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");--}}
                {{--    },--}}
                {{--    success:function(data)--}}
                {{--    {--}}
                {{--        //$('#uploaded_image').html(data);--}}
                {{--        console.log(data.data.data);--}}
                {{--    }--}}
                {{--});--}}
            }
        });
        $(document).on('click','#delete_profile_icon',function () {
            axios.post('{{route('deleteProfile')}}').then(data =>{
                var url =  data.data.url;
                $('.user_profile_image').css('backgroundImage','url("'+ url +'")');
            }).catch(error =>{

            });
        });
    </script>
@stop
