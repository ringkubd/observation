
<style>
    h1 {
        margin: 30px 10px;
    }
    .centered {
        position: relative;
        text-align: center;
    }
    .bg-white {
        background: #fff;
        color: #000;
        font-weight: bold;
        font-size: 15px;
        word-break: break-all;
        width: 100%;
        overflow: hidden;
        height: 65px;
        display: table-cell;
        vertical-align: middle;
    }
    .buttons .step {
        display: inline-block;
        text-align: center;
        margin-bottom: 25px;
    }
    .step a {
        padding: 12px;
    }
    .step h3 {
        color: #fff;
    }
</style>


<section class="form_section">
    <div class="container-fluid">
        <section class="show-area">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                       <div class="col-md-4">
                          <select class="form-control" name="client_id" id="clients" action="{{url('get-observation-home')}}" required>
                            @forelse($client_info as $clients)
                            <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                            @empty
                            @endforelse
                          </select>
                       </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center text-white">Registreringar och skattningar</h1>
                <div class="buttons centered">
                    <div class="step">
                        <h3>Vid inskrivning</h3>
                        <a href="{{url('observation-step1')}}"  stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Inskrivnings-<br>data
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 2-4 och 30</h3>
                        <a href="{{url('observation-step2')}}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Konditionstest
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br>5-6 och 31-32</h3>
                        <a href="{{url('observation-step3')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            ADL
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 6-7 och 32-33</h3>
                        <a href="{{url('observation-step4')}}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Aktiviteter och <br> idrott
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 7-8 och 33-34</h3>
                        <a href="{{url('observation-step5')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Skol- och <br> praktikfärdigheter
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 8 och 34</h3>
                        <a href="{{url('observation-step6')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Självkontroll
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 9 och 35</h3>
                        <a href="{{ url('observation-step7') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            BIR
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 10 och 36</h3>
                        <a href="{{url('observation-step8')}}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Sociala <br> färdigheter
                        </a>
                    </div>
                    <div class="step">
                        <h3>Vecka <br> 11 och 37</h3>
                        <a href="{{url('observation-step9')}}" stag_no="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag">
                            Grit
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="buttons centered">
                    <div class="step" style="max-width: 200px !important">
                        <h3>I månadsrapporten <br> varannan månad</h3>
                        <a href="{{ url('observation-step10') }}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag" style="width: 200px">
                            Rehabiliterings <br> indikatorer
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="buttons centered">
                    <h3 class="text-white">I månadsrapporten <br> varje månad</h3>
                    <div class="step" style="max-width: 200px !important;margin-right: 5px">
                        <a href="{{ url('observation-step11') }}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag" style="width: 200px">
                            Utvärdering <br> sessionsrapport
                        </a>
                    </div>
                    <div class="step" style="max-width: 200px !important">
                        <a href="{{ url('observation-step12') }}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white observation_stag" style="width: 200px">
                            Teckenekonomi <br>status
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
