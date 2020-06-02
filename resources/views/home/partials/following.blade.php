<div id="following" class="tab-pane fade">
    @if($following->count()>0)
        @foreach($following as $item2)
    <div class="list-group following_you clearfix">
        <div class="list-group-item d-inline-block">
            <div class="user_profile_image" style=" background : url('{{asset("assets/img/users/".$item2->user2->avatar)}}');
                                                                            width: 20px;
                                                                            height: 20px;
                                                                            background-size: cover;
                                                                            background-position: center;
                                                                            background-repeat: no-repeat;
                                                                            border-radius: 100px;
                                                                            float: left;
                                                                            margin-right: 20px;
                                                                    "></div>
            <div class="followingship-username float-left">{{$item2->user2->name}}</div><button class="float-right followed followingship-status">Followed</button>
        </div>
    </div>
        @endforeach
    @else
        <div class="no_report_found">
            You're currently don't have following yet!
        </div>
    @endif
</div>
