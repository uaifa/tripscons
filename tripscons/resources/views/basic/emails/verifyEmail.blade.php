@extends('basic.layout.master')

@section('main')


<main>
            <div class="login-sec" style="min-height: calc(100vh - 120px);background: url(/assets/img/login-banner.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            padding: 120px 0 0 0;font-family: Arial, Helvetica, sans-serif;">
                <div class="container">
                    <div class="thnkyou-panel" style="display: block;
                    max-width: 600px;
                    height: auto;
                    background: #fff;
                    margin: auto;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 0 30px 2px #0003;">
                       
                        <div class="img-holder"> <img src="img/thnk-icon.png" alt="Image" style=" max-width: 60px;
                            display: block;
                            margin: 25px auto;
                            height: auto;"> </div>
                        <h3 style=" font-size: 25px;
                        font-weight: 600;
                      
                        text-align: center;
                       
                        color: #008c72;"><span>Verify Your Email</span></h3>
                        <div class="email-body" style="display: block;
                        text-align: center;
                        max-width: 80%;
                        margin: auto;">
                            
                            <p style="color: #6a6a6a;
                            font-size: 13px;margin-top:20px;line-height: 27px;text-align: center;">You have entered xxxxx@gmail.com as the email address for your acount </br>
                            Please verify this email address by clicking button below
                        </p>

                             <div style="display: flex;justify-content: center;margin-top: 20px;">
                                 <a type="button" style="border:1px solid #ced4da;padding:8px 30px;border-radius: 6px;
                                 font-size: 14px;cursor: pointer;background-color: #c1dc6d;color: white;">
                                     Verify your email
                                 </a>
                             </div>
                        </div>
                    </div>
                    
                </div>
            </div>


        </main>
     
    
    
@endsection