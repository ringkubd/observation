<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step8')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}" @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 8</h1>
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
        <a href="{{ url('verktyg-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step1') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>

      <div class="col-md-12">
        <div class="text-center">
          <h4 class="text-white"> @if(!empty($Processteg8Utvarderings)){{$Processteg8Utvarderings->input_text ?? null}} @else <span class="red">Please complete stag 7 first</span>   @endif</h4>
          <h3 class="text-white">Processteg 8, utvärdering</h3>
        </div>
      </div>
    </div>
    @if(!empty(!empty($Processteg8Utvarderings)))
    <div class="panel panel-default" style="margin-top: 20px">
      <div class="panel-body">
        <form action="{{url('verktyg-step8-store')}}" method="get">
          <input type="hidden" name="client_id" value="{{$request->client_id}}">
            <input type="hidden" name="company_id" value="{{$request->company_id}}">
            <input type="hidden" name="branch_id" value="{{$request->branch_id}}">
            <input type="hidden" name="task_id" value="{{$Processteg8Utvarderings->task_id ?? $task_id ?? null}}">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <textarea name="question_1" cols="30" rows="10" class="form-control question" placeholder="Vad uppnåddes?">
                  {{$Processteg8Utvarderings->Processteg8Utvardering->question_1 ?? null}}
                </textarea>
              </div>
              <div class="form-group">
                <textarea name="question_2" cols="30" rows="10" class="form-control question" placeholder="Höll planen för genomförandet?">{{$Processteg8Utvarderings->Processteg8Utvardering->question_2 ?? null}}</textarea>
              </div>
              <div class="form-group">
                <textarea name="question_3" cols="30" rows="10" class="form-control question" placeholder="Måste något ändras?">
                  {{$Processteg8Utvarderings->Processteg8Utvardering->question_3 ?? null}}
                </textarea>
              </div>
            </div>
          </div>
      </form>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step1') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
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
