@forelse($pv_reason as $reason)
              <tr>
                <td>{{@$reason->BehavioralRegistration->input_text}}</td>
                <td class="text-center">
                  {{$reason->inervention}}
                </td>
                <td class="text-center">
                  {{$reason->utforare}}
                </td>
                <td class="text-center">
                  {{$reason->stardatum}}

                </td>
                <td class="text-center">
                  {{$reason->ovrigt}}

                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5"> No data found</td>
              </tr>
              @endforelse