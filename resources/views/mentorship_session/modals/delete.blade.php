<div class="modal scale fade" id="deleteMentorshipSessionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{route('deleteMentorshipSession')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="mentorship_session_id" value="">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete the selected session?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-flat btn-primary btn-danger submitLink">Delete Session</button>
                </div>
            </form>
        </div><!--.modal-content-->
    </div><!--.modal-dialog-->
</div><!--.modal-->
