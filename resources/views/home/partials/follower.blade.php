<div id="followers" class="tab-pane fade">
    <div class="scrollbar-inner">
        <div id="follower-show-action">
            <div class="scrollbar-inner_2">
                @if($followers->count() > 0)
                    @foreach($followers as $item)
                        <div class="list-group following_you clearfix">
                            <div class="list-group-item d-inline-block">
                                <div class="user_profile_image" style=" background : url('{{asset("assets/img/users/".$item->user1->avatar)}}');
                                    width: 20px;
                                    height: 20px;
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    border-radius: 100px;
                                    float: left;
                                    margin-right: 20px;
                                    "></div>
                                <div class="followingship-username float-left">{{$item->user1->name}}</div>
                                <button class="float-right following followingship-status" onclick=" processData('{{$item->user1_id}}', 'unfollow')">Following</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no_report_found">
                        You're currently don't have followers yet
                    </div>
                @endif
                <div class="load_more_section text-center">
                    <button> <i class="fa fa-redo"></i> Load more </button>
                </div>
            </div>
        </div>
    </div>
</div>
