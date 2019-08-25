@forelse($priyority_reason_status as $reason)
              <tr>
                <td>{{@$reason->input_text}}</td>
                <td class="text-center">
                  {{Prioriteringsskal(($reason->reason_category_id)-1) }}
                </td>

                <td class="text-center">
                  <a href="">Action</a>

                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5"> No data found</td>
              </tr>
@endforelse