@extends('layouts.app')
@section('content')
    <div class="profilePage">
        <div class="page-header full-content parallax" style="height: 200px; overflow: hidden">
            <div class="profile-info">

                <div class="profile-text light">
                    {{$user->first_name}}  {{$user->last_name}}
                    <span class="caption userRole">
                        @if($loggedInUser->userHasAccessToCRUDSystemUsers() || $loggedInUser->id == $user->id)
                            <a class="margin-left-10" href="{{route('showEditUserForm', $user->id)}}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                        @endif
                    </span>
                    <span class="caption">{{trans('messages.profile_page')}} </span>
                </div><!--.profile-text-->
            </div><!--.profile-info-->

            <div class="row breadCrumpContainer">
                <div class="">
                    <ol class="breadcrumb">
                        <li><a href="{{route('home')}}"><i class="ion-home"></i></a></li>
                        <li><a href="{{route('showAllUsers')}}">users</a></li>
                        <li><a href="#" class="active">{{$user->first_name}}  {{$user->last_name}}</a></li>
                    </ol>
                </div><!--.col-->
            </div><!--.row-->

            <div class="header-tabs scrollable-tabs sticky">
                <ul class="nav nav-tabs tabs-active-text-white tabs-active-border-yellow">
                    <li class="active"><a data-href="details" data-toggle="tab" class="btn-ripple">{{trans('messages.info')}}</a></li>
                </ul>
            </div>

        </div><!--.page-header-->

        <div class="user-profile">
            <div class="">
                <div class="tab-content without-border">
                    <div id="details" class="tab-pane active">
                        <div class="col-md-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"><h3>Basic Information</h3></div>
                                </div><!--.panel-heading-->
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="formRow row">
                                            <div class="col-md-3 formElementName">{{trans('messages.email')}}</div>
                                            <div class="col-md-9">{{$user->email}}</div>
                                        </div><!--.row-->
                                        <div class="formRow row">
                                            <div class="col-md-3 formElementName">{{trans('messages.roles.capitalF')}}</div>
                                            <div class="col-md-9">
                                                @foreach($user->roles as $role)
                                                    <b>{{$role->title}}</b>
                                                    @if(!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @if($user->created_at != null)
                                            <div class="formRow row">
                                                <div class="col-md-3 formElementName">{{trans('messages.joined.capitalF')}}</div>
                                                <div class="col-md-9">{{$user->created_at->format('d / m / Y')}}</div>
                                            </div><!--.row-->
                                        @endif
                                    </div>
                                    </div>

                                </div><!--.panel-->
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{--<div class="panel">--}}
                                {{--<div class="panel-heading">--}}
                                    {{--<div class="panel-title"><h3>Roles</h3></div>--}}
                                {{--</div><!--.panel-heading-->--}}
                                {{--<div class="panel-body">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{----}}
                                    {{--</div>--}}
                                {{--</div><!--.panel-->--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additionalFooter')
    <script>
        $( document ).ready(function() {
            var controller = new window.ProfileController();
            controller.init();
        });
    </script>
@endsection