
<style>
#container {
  width:584px;
  text-align:center;
  margin:auto;
}
#container a {
  display:block;
  color:#000;
  text-decoration:none;
  background-color:#f6f6ff;
  padding: 10px;
}
#container a:hover {
  color:#900;
}
#no1 {
  width:190px;
  border:1px solid #000;
  margin:auto;
  margin-bottom: 15px;
}
#no1 a {
  background: #8EB4E3;
}
.line {
  font-size: 0;
  width: 1px;
  color: #fff;
  background-color: #000;
  margin: 0;
}
#line1 {
  height: 140px;
  margin-left: 130px;
  clear: both;
  float: left;
}
#line1 {
  height: 241px;
  margin-left: 130px;
  clear: both;
  float: left;
}
#line2 {
  width: 1px;
  height: 20px;
  margin-left: 440px;
  margin-top: 50px;
}
#line3 {
  height: 20px;
  margin-left: 440px;
  margin-top: 84px;
}
#line4 {
  height: 20px;
  margin-left: 440px;
  margin-top: 102px;
}
#line5 {
  height: 20px;
  margin-left: 130px;
  clear: both;
  float: left;
}
#line6 {
  height: 20px;
  margin-left: 440px;
  margin-top: 138px;
}
#line7 {
  width: 56px;
  margin-top: -82px;
  margin-left: 260px;
}

#no2 {
  display: inline;
  border: 1px solid #000;
  clear: both;
  float: left;
  width: 260px;
}
#no2 a,#no3 a {
  padding: 10px;
  background: #8EB4E3;
}
#no3 {
  display:inline;
  border:1px solid #000;
  margin-left: 54px;
  float:left;
}
#no4, #no5 {
  display: inline;
  border: 1px solid #000;
  margin-left: 187px;
  float: left;
  width: 260px;
}
#no6 {
  display: inline;
  border: 1px solid #000;
  float: left;
  width: 260px;
  clear: both;
}
#no7 {
  display: inline;
  border: 1px solid #000;
  margin-left: 56px;
  float: left;
  width: 260px;
}
#no8 {
  border: 1px solid #000;
  margin: 0 auto;
  float: left;
  width: 100%;
  clear: both;
}
#no6 a {
  min-height: 92px;
}
.h-line {
  font-size: 0;
  height: 1px;
  color: #fff;
  background-color: #000;
  margin: 0;
}
.p-5 {
  padding: 5px 25px 5px 25px;
}
</style>


<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step5-chart')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}" @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 5</h1>
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
        <a href="{{ url('verktyg-step5') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-12">
        <div class="text-center">
          <h3 class="text-white">Processteg 5, analys <br><span class="red">Underkottsbeteende</span></h3>
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <form action="{{url('underkottsbeteende_store')}}" id="underkottsbeteende_form">
            <input type="hidden" name="client_id" value="{{$request->client_id}}">
            <input type="hidden" name="company_id" value="{{$request->company_id}}">
            <input type="hidden" name="branch_id" value="{{$request->branch_id}}">
            <input type="hidden" name="task_id" value="{{$underkott_behavior->task_id ?? null}}">
            <div id="container">
              <div id="no1">
                <a href="">{{$underkott_behavior->input_text ?? NULL}}</a>
              </div>
              <div id="no2">
                <a href="#">Beteendet är önskvärt men saknas</a>
              </div>
              <div id="no3">
                <a href="#">Beteendet är önskvärt men används för lite </a>
              </div>
              <div id="line1" class="line"></div>
              <div id="line2" class="line"></div>
              <div id="no4">
                <a href="#">I vilka situationer ses beteendet?</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_1"  value="{{$underkott_behavior->Underkottsbeteende->question_1 ?? NULL}}">
                </div>
              </div>
              <div id="line3" class="line"></div>
              <div id="no5">
                <a href="#">I vilka situationer används beteendet men på ett oskickligt sätt?</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_2"  value="{{$underkott_behavior->Underkottsbeteende->question_2 ?? NULL}}">
                </div>
              </div>
              <div id="no6">
                <a href="#">Kompetensbrist? Vad behöver klienten lära sig för att utföra det önskvärda beteendet?</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_3"  value="{{$underkott_behavior->Underkottsbeteende->question_3 ?? NULL}}">
                </div>
              </div>
              <div id="line4" class="line"></div>
              <div id="no7">
                <a href="#">Motivationsbrist? Har beteendet något värde för klienten? Förväntar sig klienten att klara uppgiften?<br> Motivation = Förväntan X Värde</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_4"  value="{{$underkott_behavior->Underkottsbeteende->question_4 ?? NULL}}">
                </div>
              </div>
              <div id="line5" class="line"></div>
              <div id="line6" class="line"></div>
              <div id="line7" class="h-line"></div>
              <div id="no8">
                <a href="#">Vilka vinster har klienten av att avstå från att utföra beteendet?</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_5"  value="{{$underkott_behavior->Underkottsbeteende->question_5 ?? NULL}}">
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step5') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>

  </div>
</section>

