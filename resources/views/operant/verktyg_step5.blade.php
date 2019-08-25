
<style>
.table th:first-child,.table td:first-child {
  min-width: 250px;
  padding: 8px;
}
.table th {
  text-align: center;
}
p {
  line-height: 1.2em;
  margin-bottom: 0;
}
.text-white {
  color: #fff;
}
.table.main-table>tbody>tr>td, .table.main-table >tbody>tr>th, .table.main-table >tfoot>tr>td, .table.main-table >tfoot>tr>th, .table.main-table >thead>tr>td, .table.main-table >thead>tr>th {
  vertical-align: middle;
  height: 38px;
  border: 1px solid #b5b0b0;
}
ul {
  list-style: initial;
  margin-left: 25px;
}

#container {
  width:584px;
  text-align:center;
  margin:auto;
}
#container a {
  display:block;
  color:#000;
  text-decoration:none;
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
  background: #3498DB;
  color: #fff;
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
  background: #3498DB;
  color: #fff;
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
            <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step5')}}" required>

                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h4>Steg 5</h4>
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
        <a href="{{ url('verktyg-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step6') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>

      @if(!empty($excess_behavior) || !empty($underkott_behavior))
      @if(!empty($excess_behavior))
      <div class="col-md-12">
        <div class="text-center">
          <h3 class="text-white">Processteg 5, analys <br><span class="red">Överskottsbeteende</span></h3>
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <form action="{{url('overskottsbeteende_store')}}" id="overskottsbeteende_form">
            <div class="table-responsive">
              <table class="table table-bordered main-table">
                <thead>
                  <tr style="background: #3498DB;color: #fff">
                    <th width="40%">
                      <h4 class="text-white">Stimulus/stimuli</h4>
                      Utlösande faktorer
                    </th>
                    <th width="20%">
                      Valt beteende eller benteendeklass
                    </th>
                    <th width="40%">
                      <h4 class="text-white">Konsekvenser</h4>
                      Vidmakthållande faktorer
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="background: #3498DB;color: #fff">Fundera över nedanstående:</td>
                    <td rowspan="9">
                      <input type="text" class="form-control text-center" readonly="readonly" value="{{$excess_behavior->input_text}}">
                      <input type="hidden" class="form-control task_id" value="{{$excess_behavior->task_id}}" name="task_id">
                    </td>
                    <td style="background: #3498DB;color: #fff">Fundera över nedanstående:</td>
                  </tr>
                  <tr>
                    <td>
                      <p>Vad händer före målbeteendet?</p>
                      <p>Hitta så många relevanta SD som ni kan.</p>
                      Stimuli:
                      <ul>
                        <li>Sociala</li>
                        <li>Emotionella</li>
                        <li>Situationella</li>
                        <li>Kognitiva</li>
                        <li>Fysiologiska</li>
                      </ul>
                    </td>
                    <td>
                      Vad händer efter målbeteendet?
                      Hitta så många relevanta K+ och som ni kan.
                      Vad händer som kan göra att klienten upprepar beteendet på nytt?
                      Vem responderar på klienten?
                      När förekommer denna konsekvens?
                      Vad gör andra som kan som kan påverka klientens beteende?
                       Vad tycks vidmakthålla beteendet (förstärkare)?
                      <ul>
                        <li>Sociala</li>
                        <li>Emotionella</li>
                        <li>Situationella</li>
                        <li>Kognitiva</li>
                        <li>Fysiologiska</li>
                        <li>Materiella</li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td style="background: #3498DB;color: #fff">Svara på nedanstående frågor</td>
                    <td style="background: #3498DB;color: #fff">Svara på nedanstående frågor</td>
                  </tr>
                  <tr>
                    <td>
                      När förekommer målbeteendet?
                      <input type="hidden" name="client_id" value="{{$request->client_id}}">
                      <input type="hidden" name="company_id" value="{{$request->company_id}}">
                      <input type="hidden" name="branch_id" value="{{$request->branch_id}}">
                      <input type="text" class="form-control question" name="question_1" value="{{$excess_behavior->ExcessBehavior->question_1 ?? NULL}}">
                    </td>
                    <td rowspan="3">
                      <strong>Positiv förstärkning</strong><br>
                      Vilka fördelar erhåller klienten?
                      <input type="text" class="form-control question" name="question_2"  value="{{$excess_behavior->ExcessBehavior->question_2 ?? NULL}}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Vem/vilka är närvarande?
                      <input type="text" class="form-control question" name="question_3"  value="{{$excess_behavior->ExcessBehavior->question_3 ?? NULL}}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Var befinner sig klienten?
                      <input type="text" class="form-control question" name="question_4" value="{{$excess_behavior->ExcessBehavior->question_4 ?? NULL}}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Vad sägs eller görs?
                      <input type="text" class="form-control question" name="question_5" value="{{$excess_behavior->ExcessBehavior->question_5 ?? NULL}}">
                      <br>Vem säger eller gör det?
                      <input type="text" class="form-control question" name="question_6" value="{{$excess_behavior->ExcessBehavior->question_6 ?? NULL}}">
                    </td>
                    <td rowspan="3">
                      <strong>Negativ förstärkning</strong><br>
                      Vilka negativa konsekvenser tas bort/undviks?
                      <input type="text" class="form-control question" name="question_7" value="{{$excess_behavior->ExcessBehavior->question_7 ?? NULL}}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Vad tänker, känner klienten, Inre reaktioner?
                      <input type="text" class="form-control question" name="question_8" value="{{$excess_behavior->ExcessBehavior->question_8 ?? NULL}}">
                    </td>
                  </tr>
                  <tr>
                    <td>Övrigt</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </form>
          </div>
        </div>
      </div>
      @endif
      @if(!empty($underkott_behavior))
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
            <input type="hidden" name="task_id" value="{{$underkott_behavior->task_id ?? $task_id ?? null}}">
            <div id="container">
              <div id="no1">
                <a href="">{{$underkott_behavior->input_text ?? NULL}}</a>
              </div>
              <div id="no2">
                <a href="#">Lämpligt beteende men saknas</a>
              </div>
              <div id="no3">
                <a href="#">Lämpligt beteende borde användas mer</a>
              </div>
              <div id="line1" class="line"></div>
              <div id="line2" class="line"></div>
              <div id="no4">
                <a href="#">I vilka sammanhang förekommer beteendet?</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_1"  value="{{$underkott_behavior->Underkottsbeteende->question_1 ?? NULL}}">
                </div>
              </div>
              <div id="line3" class="line"></div>
              <div id="no5">
                <a href="#">I vilka sammanhang förekommer beteendet på ett inkompetent sätt?</a>
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
                <a href="#">Vad har klienten för fördelar av att inte använda beteendet?</a>
                <div class="p-5">
                  <input type="text" class="form-control question" name="question_5"  value="{{$underkott_behavior->Underkottsbeteende->question_5 ?? NULL}}">
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
      @endif
      @else

      <div class="col-md-12">
        <div class="text-center">
          <h3 class="text-white">Processteg 5<br><span class="red">Please complete Stag 4 first</span></h3>
        </div>
      </div>

      @endif
    </div>


    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>

  </div>
</section>
