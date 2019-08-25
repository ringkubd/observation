
<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        vertical-align: middle;
    }
    .main-table-wrapper .table>tbody>tr>td:nth-child(2), .main-table-wrapper .table>tbody>tr>th:nth-child(2), .main-table-wrapper .table>tfoot>tr>td:nth-child(2), .main-table-wrapper .table>tfoot>tr>th:nth-child(2), .main-table-wrapper .table>thead>tr>td:nth-child(2), .main-table-wrapper .table>thead>tr>th:nth-child(2) {
        min-width: 100px;
        width: 100px;
    }
    .table>tbody>tr>td {
        padding: 0 5px;
        vertical-align: middle;
        font-size: 14px;
    }
    .table .form-control {
        border: 0;
        outline: 0;
        box-shadow: none;
        height: 100%;
    }
</style>

@endsection



@section('content')

<section class="form_section">
    <section class="container-fluid show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('observation-step1')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 1</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <a href="{{ url('step-list') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
        </div>
        <div class="col-md-6" style="text-align: right;">
          <a href="{{ url('observation-step2') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
        </div>
      </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div id="observationStep1" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
            </div>
        </div>
        <div class="text-center text-white bg-white p-3">
            <h2>Registrering av relevanta faktorer i relation till sammanbrott av vården</h2>
        </div>
        <div class="panel panel-default box-shadow">
            <div class="panel-heading" style="background: #D8E4BC;font-size: 16px;">                
                Notera med siffran 1 i kolumn B om påståendet stämmer
            </div>
            <div class="panel-body">
                <div class="table-responsive main-table-wrapper">
                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #DDD9C4;">
                            <th colspan="2">Variabler som beskriver barnet</th>
                        </tr>
                        <tr>
                            <td>Invandrarbakgrund minst en av föräldrarna är född utomlands</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Ensamkommet barn till Sverige</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Bristande språkförmågor</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Icke fungerande skolgång</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Problematiska kamratrelationer</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Saknar organiserade fritidsaktiviteter, med prosociala kamrater</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Trotsighet, ilska och oräddhet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Överaktivitet, impulsivitet, koncentrationssvårigheter</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Svårighet med medkänsla skuld elller ånger</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Självskadebeteende, barnet skadar avsiktligt sin kropp t.ex. genom att skära eller bränna sig</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Negativa problemlösningar, tolkningar och attityder</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Nedstämdhet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Normbrytande, provoserande beteenden</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Kriminalitet, barnet har begått flera brott eller enstaka allvarliga brott</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Alkoholanvändning</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Drogmissbruk, inklusive sniffning och ej ordinerad medicin</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet har en diagnos t.ex. ADHD, Asperger, Tourette, utvecklingsstörning eller psykiska problem i form av depression, suicidförsök, ätstörning</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet har mer än en diagnos t.ex. ADHD, Asperger, Tourette, utvecklingsstörning eller psykiska problem i form av depression, suicidförsök, ätstörning</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet tar inte ordinerad medicin</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet har problem av allvarlig grad i form av hög frånvaro eller beteendeproblem i förskolan eller skolan </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>En allvarlig eller flera polisrapporter om misshandel alternativt upprepat eller allvarligt våld i skolan, hemmet eller på fritiden</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet utsätter sig för farliga eller olämpliga kontakter via nätet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet ägnar så stor tid till nät- eller dataaktiviteter att annat i barnets utveckling blir lidande</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet prostituerar sig, har ett gravt sexuellt avvikande beteende t.ex. begår övergrepp mot andra barn, har ett mycket sexuellt utmanande beteende</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Normbrytande vänner, barnet umgås med vänner som bryter mot samhällets normer t.ex. missbrukar eller begår kriminella handlingar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Placeringen motiveras av att barnet har speciella omsorgsbehov som inte kan tillgodoses i hemmet t.ex. utifrån psykiska problem eller stora somatiska problem </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #DDD9C4;">
                            <th colspan="2">Variabler som beskriver barnets erfarenheter</th>
                        </tr>
                        <tr>
                            <td>Tidigare placerad i dygnsvård</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Tidigare placerad inom § 12-vård</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Tidigare utredning av socialtjänsten innan den utredning som föranledde placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Tidigare öppenvård inom socialtjänsten</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Långvarigt missbruk hos förälder eller annan i barnets uppväxtmiljö</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Långvarig psykisk sjukdom hos förälder eller annan i barnets uppväxtmiljö</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Sexuella övergrepp eller ofredande, eller misstanke härom, under uppväxten</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Misstanke eller konstaterand fysisk eller psykisk misshandel i hemmiljön</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Kriminell person i barnets hemmiljö under uppväxten, personen har gjort flera små eller enstaka  grova brott</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Våld i familjen under uppväxten som inte varit riktat mot barnet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Förälder med funktionsnedsättning som påverkat utövandet av föräldraskap</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Förälder med begåvningsmässig funktionsnedsättning under uppväxten</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Allvarliga konflikter mellan föräldrar, föräldrar har haft stora svårigheter att komma överens om frågor som rör barnet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
<<<<<<< HEAD
=======
                            </td>
                        </tr>
                        <tr>
                            <td>Icke fungerande skolgång</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Ekonomiska problem i hemmiljön ex kronofogde eller långvarigt försörjningsstöd</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Arbetslöshet, om minst en av barnets föräldrar har mindre än 50 % arbete</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #DDD9C4;">
                            <th colspan="2">Variabler som beskriver placeringens inledning</th>
                        </tr>
                        <tr>
                            <td>Placeras med stöd av LVU</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnets hem är < 10 mil från placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet samtycker ej till vården</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare 1 samtycker ej till vården</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare 2 samtycker ej till vården</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Påbörjas placering i samband med att föregående placering avslutas</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Akut placering</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #D8E4BC;">
                            <th colspan="2">Variabler som beskriver motiv till att barnet placeras</th>
                        </tr>
                        <tr>
                            <td>Utstötning, vårdnadshavare eller vårdgivare vägrar låta barnet bo kvar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Rymning, barnets återkommande rymningar anges som skäl till placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare har lämnat barnet hemma och bor på annan ort, sitter i fängelse eller är på sjukhus</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Det finns allvarliga misstankar om eller har konstaterats att barnet utsatts för sexuella övergrepp</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Det finns allvarliga misstankar om eller har konstaterats att barnet utsatts för psykisk eller fysisk misshandel</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet utsätts för psykisk, social och fysisk bestraffning som är kollektivt accepterat utifrån ett hederstänkande</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Relationsproblem i den biologiska familjen, barnet och föräldern/föräldrarna har levt i en långvarig konflikt</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Familjerättslig konflikt, barnet bedöms skadas av föräldrarnas konflikt eller egenmäktigt förfarande med barn </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Omvårdnad och tillsyn brister t.ex. får inte tillgång till mat, behandlas illa, får ej möjlighet till vila, </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet får inte medicinsk vård, får inte skydd mot olycksfall eller skadlig exponering i den miljö denne befinner sig</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnets utagerande sätt mot omgivningen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet använder självskadebeteenden</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet isolerar sig</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet skolkar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet vagabonderar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet utsätter sig för faror på nätet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnets sexuella aktiviteter</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet vänder på dygnet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet dricker alkohol</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet missbrukar oföreskrivna läkemedel eller andra droger</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #B7DEE8;">
                            <th>Samtycke till placeringen</th>
                            <th class="text-center">Ja</th>
                            <th class="text-center" style="min-width: 100px;width: 100px;">Nej</th>
                        </tr>
                        <tr>
                            <td>Barnet samtycker till placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare samtycker till placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #FABF8F;">
                            <th>Utskrivning</th>
                            <th class="text-center">Veckor</th>
                        </tr>
                        <tr>
                            <td>Tydligt sammanbrott (i strid med socialtjänstens önskemål eller efter socialtjänstens missnöje), inskriven antal veckor</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Sammanbrott i vid mening före måluppfyllelse (utskriven med överenskommelse, ingen idé att fortsätta), inskriven antal veckor</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Utskriven enligt planering, uppdraget slutfört</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
>>>>>>> e9976ac0aeffcabf42ebe466c1ffae5969111123
                            </td>
                        </tr>
                        <tr>
                            <td>Icke fungerande skolgång</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Ekonomiska problem i hemmiljön ex kronofogde eller långvarigt försörjningsstöd</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Arbetslöshet, om minst en av barnets föräldrar har mindre än 50 % arbete</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>
<<<<<<< HEAD

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #DDD9C4;">
                            <th colspan="2">Variabler som beskriver placeringens inledning</th>
                        </tr>
                        <tr>
                            <td>Placeras med stöd av LVU</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnets hem är < 10 mil från placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet samtycker ej till vården</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare 1 samtycker ej till vården</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare 2 samtycker ej till vården</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Påbörjas placering i samband med att föregående placering avslutas</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Akut placering</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-sm">
                        <tr style="background: #D8E4BC;">
                            <th colspan="2">Variabler som beskriver motiv till att barnet placeras</th>
                        </tr>
                        <tr>
                            <td>Utstötning, vårdnadshavare eller vårdgivare vägrar låta barnet bo kvar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Rymning, barnets återkommande rymningar anges som skäl till placeringen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Vårdnadshavare har lämnat barnet hemma och bor på annan ort, sitter i fängelse eller är på sjukhus</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Det finns allvarliga misstankar om eller har konstaterats att barnet utsatts för sexuella övergrepp</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Det finns allvarliga misstankar om eller har konstaterats att barnet utsatts för psykisk eller fysisk misshandel</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet utsätts för psykisk, social och fysisk bestraffning som är kollektivt accepterat utifrån ett hederstänkande</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Relationsproblem i den biologiska familjen, barnet och föräldern/föräldrarna har levt i en långvarig konflikt</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Familjerättslig konflikt, barnet bedöms skadas av föräldrarnas konflikt eller egenmäktigt förfarande med barn </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Omvårdnad och tillsyn brister t.ex. får inte tillgång till mat, behandlas illa, får ej möjlighet till vila, </td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Barnet får inte medicinsk vård, får inte skydd mot olycksfall eller skadlig exponering i den miljö denne befinner sig</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnets utagerande sätt mot omgivningen</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet använder självskadebeteenden</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet isolerar sig</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet skolkar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet vagabonderar</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet utsätter sig för faror på nätet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnets sexuella aktiviteter</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet vänder på dygnet</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet dricker alkohol</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        <tr>
                            <td>Eget beteende, barnet missbrukar oföreskrivna läkemedel eller andra droger</td>
                            <td>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="text-right">Total</th>
                            <th>
                                <input type="text" maxlength="1" class="form-control integer-only">
                            </th>
                        </tr>
                    </table>
=======
>>>>>>> e9976ac0aeffcabf42ebe466c1ffae5969111123
    
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <a href="{{ url('step-list') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-6" style="text-align: right;">
            <a href="{{ url('observation-step2') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
          </div>
        </div>
    </div>
</section>


@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script>
    // Create the chart
    Highcharts.chart('observationStep1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Relevanta variabler vid inskrivning samt utskrivningsorsak'
        },
        subtitle: {
            // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                // name: "Browsers",
                colorByPoint: true,
                data: [
                    {
                        name: "Belastande problematik vid placering",
                        y: 62.74,
                        drilldown: "Belastande problematik vid placering"
                    },
                    {
                        name: "Belastande erfarenheter hos barnet",
                        y: 10.57,
                        drilldown: "Belastande erfarenheter hos barnet"
                    },
                    {
                        name: "Belastande omständigheter vid placeringens inledning",
                        y: 7.23,
                        drilldown: "Belastande omständigheter vid placeringens inledning"
                    },
                    {
                        name: "Röd = Tydligt sammanbrott ",
                        y: 5.58,
                        drilldown: "Röd = Tydligt sammanbrott "
                    },
                    {
                        name: "Gul = Sammanbrott i vid mening",
                        y: 4.02,
                        drilldown: "Gul = Sammanbrott i vid mening"
                    },
                    {
                        name: "Grön = Utskriven enligt plan, måluppfyllelse",
                        y: 1.92,
                        drilldown: "Grön = Utskriven enligt plan, måluppfyllelse"
                    }
                ]
            }
        ],
    });
</script>
@endsection