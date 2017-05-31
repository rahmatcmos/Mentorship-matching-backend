@extends('layouts.auth')

@section('content')
    <div class="bg-login printable">
        <div class="login-screen">
            <div class="panel-login blur-content">
                <div class="panel-heading"><img src="{{asset('/assets/img/jobpairs_logo.png')}}" height="120" alt="">
                </div><!--.panel-heading-->

                <div id="pane-login" class="panel-body active">
                    <h2>{{ $ratedRole === 'mentor' ? "Rate your mentor" : ($ratedRole === 'mentee' ? "Rate your mentee" : '') }}</h2>
                    <p class="info-text text-center">Your mentorship session with<br>@if($ratedRole === 'mentor')
                            {{ $sessionViewModel->mentorViewModel->mentor->first_name . " " . $sessionViewModel->mentorViewModel->mentor->last_name }}
                        @else
                            {{ $sessionViewModel->menteeViewModel->mentee->first_name . " " . $sessionViewModel->menteeViewModel->mentee->last_name }}
                        @endif<br>has been completed. Please take a moment to rate your {{ $ratedRole }}.</p>
                    <form id="ratingForm" class="jobPairsForm noInputStyles" method="POST"
                          action="{{ $ratedRole === 'mentor' ? route('rateMentor') : ($ratedRole === 'mentee' ? route('rateMentee') : '') }}"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="session_id" value="{{ $sessionId }}">
                        <input type="hidden" name="mentor_id" value="{{ $mentorId }}">
                        <input type="hidden" name="mentee_id" value="{{ $menteeId }}">
                        <input type="hidden" name="rating">
                        <div id="rating-container" class="col-md-12 text-center">
                            <div class="@if ($errors->has('rating')) has-error @endif">
                                <div class="inputer rating-input-container">
                                    @for($i = 0; $i < 5; $i++)
                                        <span id="star{{ $i + 1 }}" class="glyphicon glyphicon-star-empty rating-item"></span>
                                    @endfor
                                </div>
                                @if ($errors->has('rating'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rating') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="@if ($errors->has('rating_description')) has-error @endif">
                                <div class="inputer floating-label">
                                    <div class="input-wrapper">
                                        <textarea class="form-control js-auto-size" rows="2" name="rating_description" placeholder="You may add comments about your rating">{{ old('rating_description') != '' ? old('career_goals') : '' }}</textarea>
                                    </div>
                                </div>
                                @if ($errors->has('rating_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rating_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <input type="submit" class="btn btn-primary btn-ripple" value="Rate">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-blur dark active">
            <div class="overlay"></div><!--.overlay-->
        </div><!--.bg-blur-->
    </div>
@endsection

@section('additionalFooter')
    <script>
        (function() {
            var ratingController = new window.RatingController();
            ratingController.init();
        })();
    </script>
@endsection
