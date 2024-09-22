@extends('layout.main')
@section('subtitle','Categories')
@section('content')

<div class="bg-white p-3 rounded">
  <div class="d-flex justify-content-end">
    <!-- Button trigger modal -->
    <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateCategories">
      Create
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalCreateCategories" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Categories</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formCategories">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name Categories:</label>
                <input type="text" class="form-control" name="name" id="recipient-name" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-danger">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="editForm">
              <input type="hidden" id="edit-category-id">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name Categories:</label>
                <input type="text" class="form-control" name="name" id="edit-name" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-danger" id="saveEditProduct">Update</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
  <table class="table" id="datatable">
    <thead>
      <tr>
        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10px;">No.</th>
        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name Categories</th>
        <th class="text-secondary text-center">Action</th>
      </tr>
    </thead>
    <tbody class="text-center text-sm font-weight-bolder">
   
    </tbody>
  </table>
</div>

@endsection

@push('script')
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // const table = $('#datatable').DataTable();

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('categories.table') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#formCategories').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "{{route('categories.store')}}",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          $('#modalCreateCategories').modal('hide');
          $('#formCategories')[0].reset();
          table.ajax.reload();
        },
        error: function(response) {
          console.log(response.responseJSON.message);
        }
      });
    });
    
    
    $('body').on('click', '.delete', function() {
      let id = $(this).data('id');
      if (confirm('Apakah Anda Yakin Ingin Menghapus Ini?')) {
        $.ajax({
          url: `/api/categories/${id}`,
          type: 'DELETE',
          success: function(data) {
            alert(data.message);
            table.ajax.reload(); // Refresh the list of posts
          }
        });
      }
    });
    
    
    $('body').on('click', '.edit', function() {
      let id = $(this).data('id');
      $.get("/api/categories/" + id, function(data) {
        $('#edit-category-id').val(data.id);
        $('#edit-name').val(data.name);
        $('#modalEditCategory').modal('show');
      });
    });

    $('#editForm').on('submit', function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        type: "PUT",
        url: "{{ route('categories.update', '') }}/" + $('#edit-category-id').val(),
        data: formData,
        success: function(response) {
          $('#modalEditCategory').modal('hide'); // Sembunyikan modal
          table.ajax.reload(); // Refresh tabel
        },
        error: function(response) {
          alert('Error: ' + response.responseJSON.message);
        }
      });
    });
    
  })
</script>
@endpush