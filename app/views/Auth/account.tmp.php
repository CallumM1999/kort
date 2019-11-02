@extends('inc.base')

@section('content')

    <button id="confirm-delete" class="btn btn-danger mr-2 mb-2" data-toggle="modal" data-target="#exampleModal">Delete Account</button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete your account?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            
            <form action="<?= URLROOT ?>/account/delete" method="post">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

          </div>
        </div>
      </div>
    </div>

    <script>
        // setup modal
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    </script>

@endsection
