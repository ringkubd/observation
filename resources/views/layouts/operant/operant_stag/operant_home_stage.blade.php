<section class="show-area">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                       <div class="col-md-4">
                          <select class="form-control" name="client_id" id="clients" action="{{url('get-home-stage')}}" required>
                            @forelse($client_info as $clients)
                            <option value="{{$clients->id}}" @if($request->client_id==$clients->id) selected @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
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
                <div class="buttons centered">
                    <div class="step">
                        <h3>Steg 1</h3>
                        <a href="{{ url('verktyg-step1') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            Beteende- <br>inventering
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 2</h3>
                        <a href="{{ url('verktyg-step2') }}" stag_no="2" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            Filtrering
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 3</h3>
                        <a href="{{ url('verktyg-step3') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            {{ trans('operant.prioritering') }}
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 4</h3>
                        <a href="{{ url('verktyg-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            Baslinje- <br>mätnings
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 5</h3>
                        <a href="{{ url('verktyg-step5') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            {{ trans('operant.analysis') }}
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 6</h3>
                        <a href="{{ url('verktyg-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            {{ trans('operant.strategival') }}
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 7</h3>
                        <a href="{{ url('verktyg-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            {{ trans('operant.application') }}
                        </a>
                    </div>
                    <div class="step">
                        <h3>Steg 8</h3>
                        <a href="{{ url('verktyg-step8') }}" stag_no="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="custom-btn btn-success bg-white operant_stag">
                            {{ trans('operant.evaluation') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>