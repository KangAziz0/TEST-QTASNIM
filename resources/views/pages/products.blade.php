@extends('layout.main')
@section('subtitle','Products')
@section('content')


<div class="bg-white p-3 rounded">
  <div class="d-flex justify-content-end">
    <!-- Button trigger modal -->
    <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateProduct">
      Create
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalCreateProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formProducts">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name Product:</label>
                <input type="text" class="form-control" name="name" id="recipient-name" required>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Price:</label>
                <input type="number" class="form-control" name="price" id="recipient-name" required>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Stock:</label>
                <input type="number" class="form-control" name="stock" id="recipient-name" required>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Category :</label>
                <select class="form-control" name="category" id="exampleFormControlSelect1" required>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
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


    <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
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
              <input type="hidden" id="edit-product-id">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name Product:</label>
                <input type="text" class="form-control" name="name" id="edit-name" required>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Price:</label>
                <input type="number" class="form-control" name="price" id="edit-price" required>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Stock:</label>
                <input type="number" class="form-control" name="stock" id="edit-stock" required>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Category :</label>
                <select class="form-control" name="id_category" id="edit-category" required>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
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
        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name Product</th>
        <th class=" text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Price</th>
        <th class=" text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Stock</th>
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

    const table = $('#datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "/api/productsData",
      columns: [{
          data: 'DT_RowIndex',
          name: 'no',
          orderable: false,
          searchable: false
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'price',
          name: 'price'
        },
        {
          data: 'stock',
          name: 'stock'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ]
    });
    $('#formProducts').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "{{route('products.store')}}",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          $('#modalCreateProduct').modal('hide');
          $('#formProducts')[0].reset();
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
          url: `/api/products/${id}`,
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
      $.get("/api/products/" + id, function(data) {
        $('#edit-product-id').val(data.id);
        $('#edit-name').val(data.name);
        $('#edit-price').val(data.price);
        $('#edit-stock').val(data.stock);
        $('#modalEditProduct').modal('show');
      });
    });
    // $('#saveEditProduct').click(function() {
    //   let id = $('#edit-product-id').val();
    //   let name = $('#edit-name').val();
    //   let price = $('#edit-price').val();
    //   let stock = $('#edit-stock').val();
    //   let category = $('#edit-category').val();
    //   $.ajax({
    //     url: `/api/products/${id}`,
    //     type: 'PUT',
    //     data: {
    //       name: name,
    //       price: price,
    //       stock: stock,
    //       id_category: category,
    //     },
    //     success: function(data) {
    //       $('#modalEditProduct').modal('hide');
    //       alert(data.message);
    //       table.ajax.reload();
    //     }
    //   });
    // });
    $('#editForm').on('submit', function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        type: "PUT",
        url: "{{ route('products.update', '') }}/" + $('#edit-product-id').val(),
        data: formData,
        success: function(response) {
          $('#modalEditProduct').modal('hide'); // Sembunyikan modal
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