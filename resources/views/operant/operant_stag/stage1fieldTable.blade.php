<tr>
            <td style="text-align: center;vertical-align: middle;">{{trans('label.present')}}</td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='1' && $behaveReg->behave_type=='1')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='1' && $behaveReg->behave_type=='2')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='1' && $behaveReg->behave_type=='3')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
          </tr>
          <tr>
            <td style="text-align: center;vertical-align: middle;">{{trans('label.past_tense')}}</td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='2' && $behaveReg->behave_type=='1')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='2' && $behaveReg->behave_type=='2')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='2' && $behaveReg->behave_type=='3')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
          </tr>