@extends('inc.base')

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-start align-items-center">
            <h1 class="m-0"><?= $data['name'] ?></h1>
            <span class="badge ml-2 badge-<?= ($data['enabled']) ? 'success' : 'danger' ?>">
                    <?= ($data['enabled']) ? 'Active' : 'Disabled' ?>
            </span>
        </div>
        <hr>
    </div>
    <br>

        <div class="d-flex justify-content-between flex-wrap">
            <span><a href="<?= URLROOT.'/page/'.$data['base'] ?>"><?= $data['url'] ?></a></span>
            <span>Hits <span class="badge badge-pill badge-info"><?= $data['requests'] ?></span></>
        </div>

    <br>
    <hr>
    <br>

    <a class="btn btn-primary mr-2 mb-2" href="<?= URLROOT ?>/routes/edit/<?= $data['id'] ?>">Edit</a>
    <button id="confirm-delete" class="btn btn-danger mr-2 mb-2" data-toggle="modal" data-target="#exampleModal">Delete</button>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?= $data['name'] ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this route?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a href="<?= URLROOT ?>/routes/delete/<?= $data['id'] ?>" class="btn btn-danger">Delete</a>
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
