@php
  
  $paidAmount = 0;

  if($detail->booking_detail['cart']['grandtotal'] == $detail->remaining_amount){
    $paidAmount = 0;
  }else{
    $paidAmount = ($detail->booking_detail['cart']['grandtotal'] - $detail->remaining_amount);
  }

  $heading = 'normal';
  $percentage = 0;

    if($paidAmount != 0 && $paidAmount < $detail->booking_detail['cart']['grandtotal']){
        $percentage = $detail->booking_detail['service']['payment_partial_value'];
        $heading = 'partial';
    }
  
@endphp


  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Booking Pdf Invoice</title>
  </head>
  <style>
      /* -------------------------------------
    GLOBAL
    A very basic CSS reset
------------------------------------- */

      /* Let's make sure all tables have defaults */
      * {
          font-family: Arial, Helvetica, sans-serif;
      }

      table td {
          vertical-align: top;
      }

      /* -------------------------------------
    BODY & CONTAINER
------------------------------------- */

      .body-wrap {

          width: 100%;
      }

      .right .container {
          display: block !important;
          width: 100% !important;
          margin: 0 auto !important;
          /* makes it centered */
          clear: both !important;
      }

      /* .margin-top {
    margin-top: -17px !important;
} */

      .right .content {
          width: 100%;
          margin: 0 auto;
          display: block;
          padding: 4px;
      }

      /* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
      .position_relative {
          position: relative;
      }

      .paid-status {
          position: absolute;
          top: -20px;
          right: 0px;
          font-size: 16px;
          color: #c1dc6d;
          border-bottom: 2px solid #c1dc6d;
      }

      .right .main {
          background: #fff;

          border-radius: 3px;
      }

      .right .content-wrap {
          padding: 2px;
      }

      .content-block {
          padding: 0 0 10px;
      }

      .right .header {
          width: 100%;
          margin-bottom: 10px;
      }

      .right .footer {
          width: 100%;
          clear: both;
          color: #999;
          padding: 20px;
      }

      .right .footer a {
          color: #999;
      }

      .footer p,
      .footer a,
      .footer unsubscribe,
      .footer td {
          font-size: 12px;
      }

      .modal-body {
          padding: 0px !important;
      }

      /* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
      .right h3 {
          margin-top: 10px !important;
      }

      .right h1,
      .right h2,
      .right h3 {

          color: #000;
          margin: 40px 0 0;
          line-height: 1.2;
          font-weight: 400;
      }



      .right p,
      .right ul,
      .right ol {
          margin-bottom: 10px;
          font-weight: normal;
      }

      .right p li,
      .right ul li,
      .right ol li {
          margin-left: 5px;
          list-style-position: inside;
      }

      /* -------------------------------------
    LINKS & BUTTONS
------------------------------------- */
      .right a {
          color: #1ab394;
          text-decoration: underline;
      }



      /* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
      .last {
          margin-bottom: 0;
      }

      .first {
          margin-top: 0;
      }

      .aligncenter {
          text-align: center;
      }

      .alignright {
          text-align: right;
      }

      .alignleft {
          text-align: left;
      }

      .clear {
          clear: both;
      }

      /* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
------------------------------------- */
      .alert {
          font-size: 16px;
          color: #fff;
          font-weight: 500;
          padding: 20px;
          text-align: center;
          border-radius: 3px 3px 0 0;
      }

      .alert a {
          color: #fff;
          text-decoration: none;
          font-weight: 500;
          font-size: 16px;
      }

      .alert.alert-warning {
          background: #f8ac59;
      }

      .alert.alert-bad {
          background: #ed5565;
      }

      .alert.alert-good {
          background: #1ab394;
      }

      /* -------------------------------------
    INVOICE
    Styles for the billing tableDiscount  
------------------------------------- */
      .invoice {
          margin: 20px auto;
          text-align: left;
          width: 100%;
      }

      .invoice td {
          padding: 8px 0;
      }

      .invoice .invoice-items {
          width: 100%;
      }

.invoice .invoice-items td {
    border-bottom: #f5f5 1px solid;
}

.invoice .invoice-items .total td {
    border-top: 1px solid #333;
    border-bottom: 1px solid #333;
    font-weight: 600;
}

      .custom-body {
          margin-top: -22px;
      }

      .customer_container {
          width: 100%;
          display: flex;
          justify-content: space-between;
      }
  </style>

  <body>
      <div class="container" id="testHtml">
          <div class="modal-content pdf__modal">
    
        <div class="modal-bodys" id="testHtml">
          <table class="body-wrap">
            <tbody>
              <tr>
                <td></td>
                <td class="container">
                  <div class="content">
                    <table
                      class="main"
                      width="100%"
                      cellpadding="0"
                      cellspacing="0"
                    >
                      <tbody>
                        <tr>
                          <td class="content-wrap aligncenter">
                            <table width="100%" cellpadding="0" cellspacing="0">
                              <tbody>
                                <tr>
                                  <td class="content-block">
                                    <h4 class="margin-top">
                                      Thanks for using our app
                                    </h4>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="content-block">
                                    <table class="invoice">
                                      <tbody v-if="$detail->&& $detail->user">
                                        <tr>
                                          <td class="custom_td">
                                            <span
                                              class="customer-name span_left"
                                              ><strong class="mr-2"
                                                >Customer name:</strong
                                              >
                                              {{ $detail->user->name }}
                                              </span
                                            >
                                            <span
                                              class="customer-email span_right"
                                              ><strong class="mr-2"
                                                >Customer email:</strong
                                              >
                                              {{ $detail->user->email }}
                                              </span
                                            >
                                          </td>
                                          <td>
                                            <span class="paid-status">

                                            </span>
                                          </td>
                                        </tr>

                                        <tr>
                                          <td class="custom_td">
                                            <span
                                              class="customer-invoice span_left"
                                              ><strong class="mr-2"
                                                >Invoice: </strong
                                              >
                                              {{ $detail->invoice_no }}</span
                                            >

                                            <span
                                              class="customer-invoice span_right"
                                              ><strong class="mr-2"
                                                >Invoice date:</strong
                                              >
                                              {{ $detail->created_at }}
                                            </span>
                                          </td>
                                        </tr>

                                        <tr>
                                          <td class="custom_td">
                                            <span
                                              class="customer-name span_left"
                                              ><strong class="mr-2"
                                                >Provider name:</strong
                                              >
                                              {{ $detail->provider->name }}
                                              </span
                                            >
                                            <span
                                              class="customer-email span_right"
                                              ><strong class="mr-2"
                                                >Provider email:</strong
                                              >
                                              {{ $detail->provider->email }}
                                              </span
                                            >
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="custom_td">
                                            <span class="customer-invoice span_left">
                                              <strong class="mr-2">Service:</strong>
                                              <span class="anchor-text" style="cursor:pointer; text-decoration: underline; color: #0a6cac;" onClick="checkBookingType({{$detail->reservation_type}},{{$detail->bookable}})">
                                                @if(isset($detail->bookable->title))
                                                {{ $detail->bookable->title }} 
                                                @elseif(isset($detail->booking_detail->name))
                                                  {{ $detail->booking_detail->name }}
                                                @endif
                                                ({{ $detail->reservation_type }})
                                              </span>
                                              </span>
                                             <span
                                              class="customer-invoice span_right"
                                              ><strong class="mr-2"
                                                >Payment Status:</strong
                                              >
                                              @if($detail->remaining_amount == 0)
                                              Paid
                                              @elseif($heading == 'partial' && $paidAmount != 0 && $detail->remaining_amount != 0)
                                                Partially paid {{$percentage}}%)
                                              @elseif($paidAmount == 0)
                                                Unpaid
                                              @endif
                                              </span
                                            >
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <table
                                              class="invoice-items"
                                              cellpadding="0"
                                              cellspacing="0"
                                            >
                                              <tbody>
                                                <h6 class="my-3">
                                                  <strong class="mr-2"
                                                    >Location:</strong
                                                  >
                                                  <span>
                                                    @if(isset($detail->booking_detail['service']) && !empty($detail->booking_detail['service']) && isset($detail->booking_detail['service']['location']))
                                                    {{ $detail->booking_detail['service']['location'] }} 
                                                    @endif
                                                    @if(isset($detail->booking_detail['service']['location_to']))
                                                     - {{$detail->booking_detail['service']['location_to']}}
                                                    <@endif
                                                  </span>
                                                </h6>
                                                <h6 class="my-3">
                                                  <strong class="mr-2"
                                                    >Booking status:</strong
                                                  >
                                                  <!-- Reserved -->
                                                  <span>

                                                    @if($detail->status == "0")
                                                      Pending
                                                    @elseif($detail->status == "1")
                                                      Cancelled
                                                    @elseif($detail->status == "2")
                                                      Completed
                                                    @elseif($detail->status == "3")
                                                      Not Check In
                                                    @elseif($detail->status == "4")
                                                      Close
                                                    @elseif($detail->status == "7")
                                                      Confirmed
                                                    @elseif($detail->status == "8")
                                                      Rejected
                                                    @endif
                                                  </span>
                                                </h6>
                                                <tr

                                                >
                                                  <td>Start date:</td>
                                                  <td class="alignright">
                                                    {{ $detail->date_from }}
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>End date:</td>
                                                  <td class="alignright">
                                                    {{ $detail->date_to }}
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>
                                                    <b>Items</b>
                                                  </td>
                                                  <td class="alignright">
                                                  </td>
                                                </tr>
                                                @if(!empty($detail->booking_detail) && !empty($detail->booking_detail['cart']['items']))
                                                @foreach($detail->booking_detail['cart']['items'] as $key => $item)
                                                <tr>
                                                  <td>
                                                    {{ $item['desc'] }}
                                                  </td>
                                                  <td class="alignright">
                                                    @if($item['price'] != 'FREE')
                                                      <span>{{$detail->booking_detail['cart']['currency']}}</span>
                                                    @endif
                                                    {{ $item['price'] }}
                                                  </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                  <td>
                                                    <b>Sub total</b>
                                                  </td>
                                                  <td class="alignright">
                                                    {{$detail->booking_detail['cart']['currency']}} {{$detail->booking_detail['cart']['subtotal']}}
                                                  </td>
                                                </tr>
                                                @if(isset($detail->booking_detail['cart']['discounts']) && !empty($detail->booking_detail['cart']['discounts']))
                                                <tr>
                                                  <td>
                                                    <b>Discounts</b>
                                                  </td>
                                                  <td class="alignright">
                                                  </td>
                                                </tr>
                                                @endif
                                                @if(!empty($detail->booking_detail) && !empty($detail->booking_detail['cart']['discounts']))
                                                @foreach($detail->booking_detail['cart']['discounts'] as $key => $item)
                                                <tr>
                                                  <td>
                                                    {{ $item['desc'] }}
                                                  </td>
                                                  <td class="alignright">
                                                    <span v-if="item.price != 'FREE'">{{$detail->booking_detail['cart']['currency']}}</span> {{ $item['price'] }}
                                                  </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr v-if="$detail->booking_detail.cart.discounts.length">
                                                  <td>
                                                    <b>Taxes</b>
                                                  </td>
                                                  <td class="alignright">
                                                  </td>
                                                </tr>
                                                @if(!empty($detail->booking_detail) && !empty($detail->booking_detail['cart']['taxes']))
                                                @foreach($detail->booking_detail['cart']['taxes'] as $key => $item)
                                                <tr>
                                                  <td>
                                                    {{$item['desc']}}
                                                  </td>
                                                  <td class="alignright">
                                                    <span v-if="item.price != 'FREE'">{{$detail->booking_detail['cart']['currency']}}</span> {{$item['price']}}
                                                  </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                  <td>
                                                    <b>Grand total</b>
                                                  </td>
                                                  <td class="alignright">
                                                      {{$detail->booking_detail['cart']['currency']}} {{$detail->booking_detail['cart']['grandtotal']}}
                                                  </td>
                                                </tr>
                                                @if($detail->booking_detail['cart']['grandtotal'] != $detail->remaining_amount)
                                                <tr>
                                                  <td>
                                                    <b>Paid</b>
                                                  </td>
                                                  <td class="alignright">
                                                    {{$detail->booking_detail['cart']['currency']}} 
                                                    @if($detail->booking_detail['cart']['grandtotal'] == $detail->remaining_amount)
                                                      0
                                                    @else
                                                      {{ $detail->booking_detail['cart']['grandtotal'] - $detail->remaining_amount }}
                                                    @endif
                                                  </td>
                                                </tr>
                                                @endif

                                                @if($detail->minimum_payable_amount != 0)
                                                <tr>
                                                  <td>
                                                    <b>Payable Amount</b>
                                                  </td>
                                                  <td class="alignright">
                                                    {{ $detail->booking_detail['cart']['currency'] }} {{$detail->minimum_payable_amount}}
                                                  </td>
                                                </tr>
                                                @endif
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <tr></tr>
                                <tr>
                                  <td class="content-block text-center">
                                    tripscon.com, Aqil jafri
                                    sadaat St, Lahore Pakistan
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="footer">
                      <table width="100%">
                        <tbody>
                          <tr>
                            <td class="aligncenter content-block">
                              <span class="mr-3"
                                ><em>Do you have any queries?</em></span
                              >
                              <b>Email:</b>
                              <a href="mailto:tripscon@support.com"
                                >support@tripscon.com</a
                              >
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      </div>


      <script type="text/javascript">
        function checkBookingType(reservation_type, bookable) {
          if (reservation_type && bookable) {
            if (reservation_type == 'Accomodation Booking' || reservation_type == 'Hotel Room Booking') {
              window.location.href = `/accommodations/detail/${bookable.id}`;
            } else if (reservation_type == 'Activity Booking') {
              window.location.href = `/experiences/detail/${bookable.id}`;
            } else if (reservation_type == 'Meal' || reservation_type == 'Meal Booking') {
              if (bookable.user_module_type == 'meal') {
                window.location.href = `/experiences/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'home_cheff') {
                window.location.href = `/cheff/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'restaurants') {
                window.location.href = `/restaurants/detail/${bookable.id}`;
              }
            } else if (reservation_type == 'Package Booking') {

              if (bookable.user_module_type == 'guides') {
                window.location.href = `/guides/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'visaconsultants') {
                window.location.href = `/visaconsultants/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'home_cheff') {
                window.location.href = `/cheff/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'photographers') {
                window.location.href = `/photographers/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'movie_makers') {
                window.location.href = `/moviemakers/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'restaurants') {
                window.location.href = `/restaurants/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'trip_operators') {
                window.location.href = `/tripoperators/detail/${bookable.id}`;
              }

            } else if (reservation_type == 'Service Booking') {
              if (bookable.user_module_type == 'guides') {
                window.location.href = `/guides/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'visaconsultants') {
                window.location.href = `/visaconsultants/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'home_cheff') {
                window.location.href = `/cheff/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'photographers') {
                window.location.href = `/photographers/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'movie_makers') {
                window.location.href = `/moviemakers/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'restaurants') {
                window.location.href = `/restaurants/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'trip_operators') {
                window.location.href = `/tripoperators/detail/${bookable.id}`;
              }
            } else if (reservation_type == 'Service Provider Booking') {
              if (bookable.user_module_type == 'guides') {
                window.location.href = `/guides/${bookable.id}`;
              } else if (bookable.user_module_type == 'visaconsultants') {
                window.location.href = `/visaconsultants/${bookable.id}`;
              } else if (bookable.user_module_type == 'home_cheff') {
                window.location.href = `/cheff/${bookable.id}`;
              } else if (bookable.user_module_type == 'photographers') {
                window.location.href = `/photographers/${bookable.id}`;
              } else if (bookable.user_module_type == 'movie_makers') {
                window.location.href = `/moviemakers/${bookable.id}`;
              } else if (bookable.user_module_type == 'restaurants') {
                window.location.href = `/restaurants/${bookable.id}`;
              }
            } else if (reservation_type == 'Transport/Vehicle' || reservation_type == 'Transport/Vehicle Booking') {
              if (bookable.user_module_type == 'transports') {
                window.location.href = `/vehicles/detail/${bookable.id}`;
              } else if (bookable.user_module_type == 'transport_company') {
                window.location.href = `/transport-company/detail/${bookable.id}`;
              }
            }
          }
        }
      </script>
  </body>

  </html>


