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
          <table class="body-wrap">
              <tbody>
                  <tr>
                      <td></td>
                      <td class="container">
                          <div class="content">
                              <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                  <tbody>
                                      <tr>
                                          <td class="content-wrap aligncenter">
                                              <table width="100%" cellpadding="0" cellspacing="0">
                                                  <tbody>
                                                      <tr>
                                                          <td class="content-block">
                                                              <h4 class="margin-top" style="text-align: center;">
                                                                  Thanks for using our app
                                                              </h4>
                                                          </td>
                                                      </tr>

                                                      <tr>
                                                          <td class="content-block">
                                                              <table class="invoice">
                                                                  <tbody>
                                                                      <tr class="position_relative">
                                                                          <td >
                                                                              <div class="customer_container" >


                                                                                  <span class="customer-name"><strong class="mr-2">Customer Name:</strong>
                                                                                      {{$detail->User->name}} </span>
                                                                                  <span class="customer-email  ml-5" style="margin-left: auto;"><strong class="mr-2">Customer Email:</strong>
                                                                                      {{$detail->user->email}} </span>
                                                                              </div>
                                                                              <br />
                                                                              <div class="customer_container">
                                                                                  <span class="customer-invoice"><strong class="mr-2">Invoice:</strong>
                                                                                      #{{@$detail->Invoice->number}}</span>
                                                                                  @if($detail->provider_name == "service provider")
                                                                                  <span class="customer-invoice ml-5"><strong class="mr-2">Booking Type:</strong>
                                                                                      {{$detail->booking_type}}
                                                                                  </span>
                                                                                  @endif

                                                                                  <span class="customer-invoice"><strong class="mr-2">Invoice Date:</strong> {{ date('Y-m-d', strtotime(@$detail->Invoice->created_at)) }}
                                                                                  </span>
                                                                              </div>
                                                                          </td>
                                                                          <td>
                                                                              <span class="paid-status">
                                                                                  @if(@$detail->Invoice->status == 0)
                                                                                  Unpaid
                                                                                  @elseif(@$detail->Invoice->status == 1)
                                                                                  Paid
                                                                                  @elseif(@$detail->Invoice->status == 2)
                                                                                  partial Payment
                                                                                  @endif
                                                                              </span>
                                                                          </td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>
                                                                              <div class="customer_container">
                                                                                  <span class="customer-name"><strong class="mr-2">Provider Name:</strong>
                                                                                      {{@$detail->Provider->name}} </span>
                                                                                  <span class="customer-email ml-5"><strong class="mr-2">Provider Email:</strong>
                                                                                      {{@$detail->Provider->email}} </span>
                                                                              </div>
                                                                          </td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>
                                                                              <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                                                  <tbody>
                                                                                      @if(@$detail->module_name == 'experiences')
                                                                                      <p>
                                                                                          <strong class="mr-2">Title</strong>:
                                                                                          {{@$detail->Experience->title}}
                                                                                      </p>
                                                                                      <p class="my-3">
                                                                                          <strong class="mr-2">Location</strong>:
                                                                                          {{@$detail->slotBook->Slot->location}}
                                                                                      </p>

                                                                                      @elseif(@$detail->module_name == 'guideprofile')
                                                                                      <p>
                                                                                          <strong class="mr-2">Title</strong>:
                                                                                          {{@$detail->Provider->name}}
                                                                                      </p>
                                                                                      <p class="my-3">
                                                                                          <strong class="mr-2">Location</strong>:
                                                                                          {{@$detail->Provider->address}}
                                                                                      </p>
                                                                                      @else
                                                                                      <span>
                                                                                          <strong class="mr-2">Title</strong>:
                                                                                          {{@$detail->Accommodation->title}}
                                                                                      </span>
                                                                                      <p class="my-3">
                                                                                          <strong class="mr-2">Location</strong>:
                                                                                          {{@$detail->Accommodation->location}}
                                                                                      </p>
                                                                                      @endif

                                                                                      <p class="my-3">
                                                                                          <strong class="mr-2">Booking Status</strong>
                                                                                          : @if($detail->status == 0)
                                                                                          pending
                                                                                          @elseif($detail->status == 1)
                                                                                          Cancel
                                                                                          @elseif($detail->status == 2)
                                                                                          Complete
                                                                                          @elseif($detail->status == 3)
                                                                                          Not CheckIn
                                                                                          @elseif($detail->status == 4)
                                                                                          close
                                                                                          @endif
                                                                                      </p>

                                                                                      @if($detail->module_name == 'accommodations')
                                                                                      <tr>
                                                                                          <td>Start Date</td>
                                                                                          <td class="alignright">
                                                                                              {{ date('Y-m-d', strtotime(@$detail->start_date)) }}

                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>End Date</td>
                                                                                          <td class="alignright">
                                                                                              {{ date('Y-m-d', strtotime(@$detail->end_date)) }}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>No of Nights</td>
                                                                                          <td class="alignright">
                                                                                              {{ $detail->no_of_nights}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Per Night</td>
                                                                                          <td class="alignright">
                                                                                              {{ $detail->Accommodation->per_night}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @if($detail->Accommodation->breakfast_price && $detail->Accommodation->breakfast_price!= 0)
                                                                                      <tr>
                                                                                          <td>Breakfast</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->Accommodation->breakfast_price}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @if($detail->Accommodation->lunch_price && $detail->Accommodation->lunch_price!= 0)

                                                                                      <tr>
                                                                                          <td>Lunch</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->Accommodation->lunch_price}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @if($detail->Accommodation->dinner_price && $detail->Accommodation->dinner_price!= 0)

                                                                                      <tr>
                                                                                          <td>Dinner</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->Accommodation->dinner_price}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @if($detail->Accommodation->service_fee>0)

                                                                                      <tr>
                                                                                          <td>Service fee</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->Accommodation->service_fee}}

                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @if($detail->Accommodation->cleaning_fee>0)

                                                                                      <tr>
                                                                                          <td>Cleaning fee</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->Accommodation->cleaning_fee}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @endif
                                                                                      @if($detail->module_name == 'meals')
                                                                                      <tr>
                                                                                          <td>Require Date </td>
                                                                                          <td class="alignright">:
                                                                                              {{$detail->MealBookingDetail->require_date}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Require Time </td>
                                                                                          <td class="alignright">:
                                                                                              {{$detail->MealBookingDetail->require_time}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td> unit </td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->Meal->price}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Total unit </td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->no_of_nights}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @if($detail->module_name == 'transports')
                                                                                      <tr>

                                                                                          <td>Start Date</td>
                                                                                          <td class="alignright">
                                                                                              {{ date('Y-m-d', strtotime($detail->start_date)) }}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>End Date</td>
                                                                                          <td class="alignright">
                                                                                              {{ date('Y-m-d', strtotime($detail->end_date)) }}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td> Booking Type </td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->VehicleBookingDetail->booking_type}}

                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Total Days</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->no_of_nights}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      @if($detail->module_name == 'experiences')
                                                                                      <tr>
                                                                                          <td>Start Date</td>
                                                                                          <td class="alignright">
                                                                                              {{@$detail->slotBook->Slot->date}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Duration</td>
                                                                                          <td class="alignright">
                                                                                              {{@$detail->slotBook->Slot->duration}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Class Size</td>
                                                                                          <td class="alignright">
                                                                                              {{@$detail->slotBook->Slot->class_size}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>joining Persons</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->ExperienceBookingDetail->no_of_childs + $detail->ExperienceBookingDetail->no_of_adults}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td>Per Person</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->slotBook->Slot->price}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      <tr>
                                                                                          <td>SubTotal</td>
                                                                                          <td class="alignright">
                                                                                              {{$detail->sub_total}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr class="total">
                                                                                          <td>Total</td>
                                                                                          <td class="alignright">
                                                                                              PKR {{$detail->total}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @if($detail->discount && $detail->discount > 0)
                                                                                      <tr class="total">
                                                                                          <td class="">Discount</td>
                                                                                          <td class="alignright">
                                                                                              PKR {{$detail->discount}}
                                                                                          </td>
                                                                                      </tr>
                                                                                      @endif
                                                                                      <tr class="total">
                                                                                          <td>Grand Total</td>
                                                                                          <td class="alignright">
                                                                                              PKR {{$detail->grand_total}}
                                                                                          </td>
                                                                                      </tr>

                                                                                      @if($detail->partial_amt > 0 && $detail->module_name =='accommodations')
                                                                                      <tr class="total">
                                                                                          <td>Partial Amount</td>
                                                                                          <td class="alignright">
                                                                                              PKR {{$detail->partial_amt}}
                                                                                              {{$detail->partial_amt_in_percentage}} %

                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr class="total">
                                                                                          <td>Remainig Amount</td>
                                                                                          <td class="alignright">
                                                                                              PKR {{$detail->grand_total - $detail->partial_amt}}
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
                                                          <td class="content-block">
                                                              Company Wanological Solutions. Aqil Jafri
                                                              Sadaat St, Lahore Pakistan
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
                                                  <span class="mr-3"><em>Do you have any queries?</em></span>
                                                  <b>Email:</b>
                                                  <a href="mailto:">tripsconpro@company.inc
                                                  </a>
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

  </body>

  </html>
  <div>