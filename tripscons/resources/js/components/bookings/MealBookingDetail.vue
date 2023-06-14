<template>
      <div><tr>
                                                            <td>Require Date </td>
                                                            <td class="alignright">{{bookingDetailObj.require_date |formatDate}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Require Time </td>
                                                            <td class="alignright">{{bookingDetailObj.require_time }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td>{{unit }} </td>
                                                            <td class="alignright">{{bookingObj.price.toFixed(2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total {{unit}} </td>
                                                            <td class="alignright">{{bookingObj.no_of_nights }} * {{bookingObj.price.toFixed(2) }}</td>
                                                        </tr>
                                                        </div>
</template>
 <script>
  export default {
  name: "MealBookingDetail",
  props:['bookingDetailObj','bookingObj'],
};

</script>