@extends('layout.main')
@section('subtitle','Transaction Report')
@section('content')
<div class="bg-white p-3 rounded">
  <table class="table" id="datatable">
    <thead>
      <tr>
        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10px;">No.</th>
        <th class=" text-center text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name Category</th>
        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Total Sold</th>
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
            url: "{{ route('report.table') }}",
            type: 'GET',
            data: function(d) {
                d.start_date = $('#start_date').val();     // Start date filter
                d.end_date = $('#end_date').val();         // End date filter
            }
        },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'total_sold',
          name: 'total_sold'
        },

      ]
    });
  })
</script>

@endpush