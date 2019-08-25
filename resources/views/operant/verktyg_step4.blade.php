
<style>
.table th:first-child,.table td:first-child {
  min-width: 250px;
  padding: 8px;
}
.table>thead>tr>th {

}
.table>tbody>tr>td {
  padding: 0;
}
.table>tbody>tr>td>input, .table>tfoot>tr>th>input {
  border: 0;
}
.table.main-table>tbody>tr>td, .table.main-table >tbody>tr>th, .table.main-table >tfoot>tr>td, .table.main-table >tfoot>tr>th, .table.main-table >thead>tr>td, .table.main-table >thead>tr>th {
  /*background: #d3d3d3;*/
  vertical-align: middle;
  padding: 0 5px;
  height: 38px;
  border: 1px solid #b5b0b0;
  text-align: center;
}

/* radio or checkbox start */
.form-group.checkbox {
  display: inline-block;
}

.form-group.checkbox input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.form-group.checkbox label {
  position: relative;
  cursor: pointer;
  padding-left: 5px;
}

.form-group.checkbox label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  border: 2px solid #0079bf;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
}

.form-group.checkbox input:checked + label:after {
  content: '';
  display: block;
  position: absolute;
  top: 3px;
  left: 15px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
/* radio or checkbox end */
</style>

<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step4')}}" required>

                @forelse($client_info as $clients)
                <option value="{{$clients->id}}" @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 4</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step3') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step5') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
      @if(!empty($baseline))

      <div id="dynamic_script">
        @include('operant.operant_stag.vecca_dynamic_script')
      </div>
      <h3 class="text-center red">{{$baseline->text_field ?? null}}</h3>
      <h2 class="text-center text-white">Baslinjematning</h2>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body dynamic_vecca_table">
            
            @forelse($baseline->TotalBlockBaseLine as $baseline_data)
            @include('operant.operant_stag.vecca_dynamic_table',['loops'=>$baseline_data->block_id,'looplast'=>$loop->last])
            @empty
            @include('operant.operant_stag.vecca_dynamic_table',['loops'=>1,'looplast'=>1])
            @endforelse


          </div>
          
              <div class="text-right">
                <button class="btn btn-primary add_new_vecca"  @if(empty($default_base_line)) style="display: none;" @endif day_present="{{$request->day_present ?? $default_base_line->day_present ?? 14}}" attr_url="{{url('add-vecca')}}"  class="form-control vecca_no vecca_no{{count($baseline->TotalBlockBaseLine)}}" block_id="{{count($baseline->TotalBlockBaseLine)+1}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}"><i class="fa fa-plus"></i></button>
              </div>
          
        </div>
      </div>
      @else
      <h3 class="text-center red">Please complete stag 3 first</h3>
      <h2 class="text-center">Baslinjematning</h2>
      @endif

    </div>


    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step3') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step5') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>

  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form action="{{ url('operant_step4_comment') }}" method="post" id="commentForm">
      {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="operant_comment">{{trans('label.comment')}} <span class="text-danger">*</span></label>
                <textarea name="operant_comment" class="form-control" id="operant_comment" cols="5"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default comment_close" data-dismiss="modal">{{ trans('dashboard.close') }}</button>
            <button type="submit" class="btn btn-success comment_submit" value="0">{{ trans('dashboard.submit') }}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(".datepicker").datepicker({
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    onSelect:function(selected) {
      $("#start_date_add").datepicker("option","maxDate", selected);
      $(this).valid();
    },
  });
  $(document).on('click','.commentBtn,.fileBtn',function(e){

    var day_id = $(this).attr('day_id');
    var block_id = $(this).attr('block_id');
    var stag_no = $(this).attr('stag_no');
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var task_id = $(this).attr('task_id');

    $('#commentModal').modal('show');
    $(".comment_submit").attr({
      day_id: day_id,
      block_id: block_id,
      stag_no: stag_no,
      client_id: client_id,
      branch_id: branch_id,
      company_id: company_id,
      task_id: task_id
    });
    $('#operant_comment').text('');
    $.ajax({
      url: '{{ url('get-operant-comment') }}',
      type: 'GET',
      data: {
        day_id: day_id,
        block_id: block_id,
        stag_no: stag_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      //console.log(data);
      $('#operant_comment').text(data.input_text);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });

  });
  $(document).on('click', ".comment_submit", function(e) {
    e.preventDefault();
    var day_id = $(this).attr('day_id');
    var block_id = $(this).attr('block_id');
    var stag_no = $(this).attr('stag_no');
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var input_text = $('#operant_comment').val();
    $.ajax({
      url: '{{ url('store-operant-comment') }}',
      type: 'GET',
      data: {
        input_text: input_text,
        day_id: day_id,
        block_id: block_id,
        stag_no: stag_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      Swal.fire(
        'Spara!',
        'Sparade framgångsrikt!',
        'success'
      )
      $('#commentModal').modal('hide');
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
</script>
