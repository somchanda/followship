@extends('layout.main')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="itemise_inner">
                <a href="{{route('logout')}}" class="logout_action"><i class="fas fa-power-off"></i> logout</a>
                <div class="profile_section_inner" style="padding-top: 40px;">
                    <div class="user_profile_image" style="background: url({{asset('assets/img/users/'.Auth::user()->avatar)}});
                                width: 100px;
                                height: 100px;
                                background-position: center;
                                background-size: contain;
                                border-radius: 100%;
                                border: 2px solid #f4f4f4;
                                margin: 0 auto;
                                margin-bottom: 30px;">
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
        //to prevent reload page when user click submit form
        $(document).on('submit','#userSearchForm',function (event) {
            event.preventDefault();
        });
        //to handle search function
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
    </script>
@stop
