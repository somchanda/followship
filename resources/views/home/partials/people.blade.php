<div id="people" class="tab-pane fade">
    <form id="userSearchForm">
        <input id="userSearchInput" class="se_people" type="text" placeholder="Search for people by username">
        <button class="se_people_icon"><i class="fa fa-search"></i></button>
    </form>


    <div class="scrollbar-inner">
        <div class="scrollbar-inner_2">
            <div id="searchResult">
                <div class="list-group following_you clearfix">
                    @foreach($user as $people)
                        <div class="list-group-item d-inline-block">
                            <div class="user_profile_image" style=" background : url('{{asset("assets/img/users/".$people->avatar)}}');
                                                                                            width: 20px;
                                                                                            height: 20px;
                                                                                            background-size: cover;
                                                                                            background-position: center;
                                                                                            background-repeat: no-repeat;
                                                                                            border-radius: 100px;
                                                                                            float: left;
                                                                                            margin-right: 20px;
                                                                                    "></div>
                            <div class="followingship-username float-left">{{$people->name}} </div>
                            @if(isFollowing($people->id)=='following')
                                <button class="float-right followed followingship-status" onclick="processData('{{$people->id}}','unfollowing')">Followed</button>
                            @elseif(isFollowing($people->id)=='follower')
                                <button class="float-right following followingship-status" onclick="processData('{{$people->id}}','unfollow')">Following</button>
                            @else
                                <button class="float-right followed followingship-status" onclick="processData('{{$people->id}}','follow')">Follow</button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
