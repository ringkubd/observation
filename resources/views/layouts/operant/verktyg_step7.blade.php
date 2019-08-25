
<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step7')}}" required>
                <option value="">{{trans('activity_upcoming.select_client')}}</option>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}" @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 7</h1>
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
        <a href="{{ url('verktyg-step6') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step8') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>

      <div class="col-md-12">
        <div class="text-center">
          <h4 class="text-white"> @if(!empty($Processteg7Tillampas)){{$Processteg7Tillampas->input_text ?? null}} @else <span class="red">Please complete stag 6 first</span>   @endif</h4>
          <h3 class="text-white">Processteg 7, tillämpa</h3>
        </div>
      </div>
    </div>
    @if(!empty($Processteg7Tillampas))
    <div class="panel panel-default" style="margin-top: 20px">
      <div class="panel-body">
        <form action="{{url('verktyg-step7-store')}}" method="get">
          <input type="hidden" name="client_id" value="{{$request->client_id}}">
            <input type="hidden" name="company_id" value="{{$request->company_id}}">
            <input type="hidden" name="branch_id" value="{{$request->branch_id}}">
            <input type="hidden" name="task_id" value="{{$Processteg7Tillampas->task_id ?? $task_id ?? null}}">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <textarea  cols="30" rows="10" class="form-control question" name="question_1" placeholder="Notera eventuella svårigheter att följa planen">{{$Processteg7Tillampas->Processteg7Tillampa->question_1 ?? null}}</textarea>
            </div>
            <div class="form-group">
              <textarea  cols="30" rows="10" class="form-control question" name="question_2" placeholder="Notera eventuella avvikelser från planen"> {{$Processteg7Tillampas->Processteg7Tillampa->question_2 ?? null}}</textarea>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step8') }}" stag_no="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>


  </div>
</section>

<script>
  $(document).ready(function(){
    $('.add_btn').click(function(event) {
      var inputs = $(this).parents('table').find('tr');
      var name = $(this).parents('table').attr('id');
      var id = inputs.length;
      $(this).parents('table').find('tbody').append('<tr><td><div class="form-group checkbox"><input autocomplete="off" class="" id="'+name+id+'" name="" type="checkbox"> <label for="'+name+id+'"></label></div><input class="form-control input_text" name="field_name" type="text" autocomplete="off"></td></tr>');
    });

  });

</script>

