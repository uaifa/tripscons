 
 <main>

  <div
    style="
      width: 100%;
      min-height: calc(100vh - 120px);
      font-family: Arial, Helvetica, sans-serif;
    "
  >
    <div
      style="
        max-width: 840px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 20px;
        background-color: #fff;
      "
    >
    <div style="width:100%;height:200px;">
       <img src="https://i.ibb.co/f4WSSRd/finalbanner.png"   style="border-radius:12px;object-fit:contain;max-width:100%;height:200px;" alt="" srcset="">
      </div>
      <div
        style="
          width: 100%;
          display: flex;
          justify-content: start;
          margin: 20px 0px 40px;
          align-items: center;
         
        "
      >
       
        
         <div style="
              width:42px;
             height:auto;
             
              
              
            ">
            <img src="https://i.ibb.co/bvPJRk6/synchronize.png" alt="" srcset="" style="width:42px;
             height:auto;
             ">
            </div>
            <h2 style="margin-left:8px;font-size:16px;font-weight:bold;">Do you want to reset your account password?</h2>
       
      </div>

   <h2 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px">Hello {{$data->data['name']}},</h2>
        <h4 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px">
       We received a request to reset your existing password for the account associated with the email    <span
          href="https://www.linkedin.com/company/tripscon"
          style="
            font-size: 15px;
            color: #0a6cac;
           
            font-weight: 500;
          "
          >{{$data->data['email']}} </span>.
          

       
      </h4>
      <h4 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px">
        Here is your password reset link so you can  update your password now:
      </h4>
      <h6 style="font-size: 14px; font-weight: 400; margin: 20px 0px">
      
      Click here:  <a
      href="{{config('app.FRONT_END_BASE_PATH')}}/forgot-password/{{$data->data['token']}}/{{$data->data['user_id']}}"
          style="
            font-size: 15px;
            color: #0a6cac;
            text-decoration: underline;
            font-weight: 600;
          "
          >Reset password</a
        >
      </h6>
     <h4 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px"> If you don't want to reset your password, please ignore this email.</h4>
     

     
     
      <div style="margin: 10px 0px">
        
        <h2 style="font-size: 16px; font-weight: 600; margin: 40px 0px 10px">
          Team Tripscon
        </h2>
      </div>
       <h4 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px">
        For latest news and updates about Tripscon, follow us:
      </h4>
       <div
        style="display: flex;"
      >
        <a
          href="https://www.facebook.com/Tripscon"
          style="
            font-size: 15px;
            color: #0a6cac;
            text-decoration: underline;
            font-weight: 600;
          "
          > <img src="https://i.ibb.co/J7v5kHX/facebook.png" alt="" style="width:21px;height:21px; margin-right:10px;">  </a
        >
        <a
          href="https://instagram.com/tripscon_?igshid=YmMyMTA2M2Y="
          style="
            font-size: 15px;
            color: #0a6cac;
            text-decoration: underline;
            font-weight: 600;
          "
          ><img src="https://i.ibb.co/54RSD7b/instagram.png" alt="" style="width:21px;height:21px; margin-right:10px;"></a
        >
        <a
          href="https://www.linkedin.com/company/tripscon"
          style="
            font-size: 15px;
            color: #0a6cac;
            text-decoration: underline;
            font-weight: 600;
          "
          >
          <img src="https://i.ibb.co/JcykGTs/linkedin.png" alt="" style="width:21px;height:21px; margin-right:10px;">
          
         </a
        >
        <a
          href="https://www.youtube.com/channel/UCRBnXK5u4GJccWKMad2FQaw?app=desktop"
          style="
            font-size: 15px;
            color: #0a6cac;
            text-decoration: underline;
            font-weight: 600;
          "
          ><img src="https://i.ibb.co/nB483s7/youtube.png" alt="" style="width:21px;height:21px; margin-right:10px;"></a
        >
      
      </div>
    </div>
  </div>


</main>
