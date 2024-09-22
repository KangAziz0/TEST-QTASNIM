@extends('layout.main')
@section('subtitle','Sale Transaction')
@section('content')

<div class="bg-white p-3 rounded">
  <div class="d-flex justify-content-end">
    <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateTrans">
      Create
    </button>
    <!-- Modal -->
    <div class="modal fade" id="modalCreateTrans" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Transaction</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formTransactions">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Category:</label>
                <select name="category" id="category" class="form-control">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name Product:</label>
                <select class="form-control" id="product" name="id_product">
                </select>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Sold:</label>
                <input type="number" class="form-control" name="sold" id="recipient-name" required>
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
  </div>

  <div class="filters ml-1" id="filters" style="display: none;">
    <select class="form-control" id="category_filter" style="display: inline-block;">
      <option value="">Category</option>
      @foreach($categories as $category)
      <option value="{{$category->id}}">{{$category->name}}</option>
      @endforeach
    </select>
  </div>

  <table class="table" id="datatable">
    <thead>
      <tr>
        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10px;">No.</th>
        <th class="text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Transaction Date</th>
        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name Product</th>
        <th class=" text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Stock</th>
        <th class=" text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Sold</th>
        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Category</th>
        <!-- <th class="text-secondary text-center">Action</th> -->
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

    var table = $('#datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route("transaction.table") }}',
        data: function(d) {
          d.category_filter = $('#category_filter').val()
          // return d
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'date_transaction',
          name: 'date_transaction'
        },
        {
          data: 'product',
          name: 'product'
        },
        {
          data: 'stock',
          name: 'stock'
        },
        {
          data: 'sold',
          name: 'sold'
        },
        {
          data: 'category',
          name: 'category'
        },

      ]
    });

    $('#category').on('change', function() {
      var categoryId = $(this).val(); // Ambil ID kategori

      // Kosongkan pilihan produk setiap kali kategori diubah
      $('#product').empty();

      if (categoryId) {
        // AJAX request ke server untuk mendapatkan produk berdasarkan kategori
        $.ajax({
          url: '/api/get-products/' + categoryId,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $.each(data, function(key, value) {
              $('#product').append('<option value="' + key + '">' + value + '</option>');
            });
          }
        });
      }
    });


    $('#formTransactions').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "{{route('transactions.store')}}",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          $('#modalCreateTrans').modal('hide');
          $('#formTransactions')[0].reset();
          table.ajax.reload();
        },
        error: function(response) {
          console.log(response.responseJSON.message);
        }
      });
    });

    $('.filters').insertAfter('.dt-search input').css('display', 'inline-block').css('margin-left','10px');
    $("#category_filter").on('change',function(){
      let filter = $('#category_filter').val();
      table.draw();
    })
    

  })
</script>

@endpush