 
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
      <div
        style="
          width: 100%;
          display: flex;
          justify-content: space-between;
          margin: 10px 0px;
          height:100px;
          background: #0a6cac;
          padding:9px;
          border-radius:12px;
          align-items: center;
        "
      >
        <div style="height: 50px; width: auto">
          <img
            src="https://i.ibb.co/sg6pdhf/header.png"
            alt="logo"
            border="0"
            style="max-width: 100%; height: 100%"
          />
        </div>
        
      </div>
      <div
        style="
          width: 100%;
          display: flex;
          justify-content: start;
          margin: 20px 0px 20px;
          align-items: center;
         
        "
      >
       
        
       
            <h2 style="font-size:16px;font-weight:bold;">Confirm your email address on Tripscon</h2>
       
      </div>

   <h2 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px"> {{$data->data['name']}},</h2>
        <h4 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px">
        Thanks for signing up on Tripscon. For the purpose of verification and security, we want you to confirm your email address.  
          

       
      </h4>
      <h4 style="font-size: 15px; font-weight: 500; margin: 20px 0px 10px">
       Please click on following link to verify your email address
      </h4>
      @if($data->data && isset($data->data['guest_user']) && $data->data['guest_user'] && $data->data['guest_user'] == 1)
        <h6 style="font-size: 14px; font-weight: 400; margin: 20px 0px">
          <strong>Email: </strong> {{ $data->data['email'] }}
        </h6>
        <h6 style="font-size: 14px; font-weight: 400; margin: 20px 0px">
          <strong>Password: </strong> {{ $data->data['random_password'] }}
        </h6>
      @endif

      <h6 style="font-size: 14px; font-weight: 400; margin: 20px 0px">
      
      Click here:  <a 
      href="{{config('app.FRONT_END_BASE_PATH')}}/verify_account/{{$data->data['token']}}/{{base64_encode($data->data['email'])}}"
          style="
            font-size: 15px;
            color: #0a6cac;
            text-decoration: underline;
            font-weight: 600;
          "
          >Confirm email</a
        >
      </h6>
    
     

     
     
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
