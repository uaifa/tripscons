<p>&nbsp;</p>
<div style="display: block; max-width: 650px; margin: 0 auto;">
	<table style="width: 100%; height: 533px;">
		<tbody>
			<tr style="height: 195px;">
				<td style="vertical-align: top; height: 195px; width: 1.53846%;" colspan="2">
					<div class="pdf-logo" style="padding: 15px 0 15px; text-align: center; width: 100%; margin: 0 auto 15px;">
						<img src="{{ asset('/')}}assets/img/logo_white.png?tr=w-200" alt="logo" width="300px" />
						
					</div>
				</td>
			</tr>
			<tr style="height: 78px;">
				<td style="vertical-align: top; height: 78px; width: 1.53846%;" colspan="2">
					<div style="padding: 25px 0;"><strong style="font-size: 25px; color: #3d3d3d; text-transform: uppercase; font-weight: 600;">Welcome!</strong></div>
				</td>
			</tr>
			<tr style="height: 136px;">
				<td style="height: 136px; width: 1.53846%;" colspan="2">
					<div class="order-detials-sec">Hello {{$user->name}},</div>
					<div class="order-detials-sec">&nbsp;</div>
					<div class="order-detials-sec">Thank you for signing up with Tripscon. Your account has been successfully created.</div>

					<div class="order-detials-sec">&nbsp;</div>
					<div class="order-detials-sec">
						<strong>Email:</strong> {{ $user->email }}
					</div>
					<div class="order-detials-sec">
						<strong>Password:</strong> {{ $user->random_password }}
					</div>
					
					<div class="order-detials-sec">&nbsp;</div>
					<div class="order-detials-sec">
						<p><a class="verify-btn" style="display: block; max-width: 150px; background: #008c72; text-align: center; padding: 15px; color: #fff; text-decoration: none; border-radius: 25px; margin: 10px 0 20px;" href="{{url('/')}}">Login</a></p>
					</div>
				</td>
			</tr>
			<tr style="height: 67px;">
				<td style="height: 67px; width: 1.53846%;" colspan="2">
					<p style="margin: 0 0 1px;">Regards,</p> <strong style="margin: 0 0 30px; display: block;">The Tripscon Team</strong></td>
			</tr>
		</tbody>
	</table>
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td>
					<div class="footer" style="display: block; background: url('https://admin.ihealer.com/email_assets/images/footer.jpg'); background-repeat: no-repeat; background-size: cover; height: 70px; padding: 10px;">
						<ul class="social-icon" style="list-style: none; margin: 20px auto 0; display: block; text-align: center;">
							<li style="display: inline-block; margin: 0 10px 0 0;">
								<a href="#"><img style="max-width: 35px; margin: 0; height: auto; display: inline-block; box-shadow: 0 5px 15px 0 #fff; border-radius: 25px;" src="https://admin.ihealer.com/email_assets/images/1.png" alt="facebook" /></a>
							</li>
							<li style="display: inline-block; margin: 0 10px 0 0;">
								<a href="#"><img style="max-width: 35px; margin: 0; height: auto; display: inline-block; box-shadow: 0 5px 15px 0 #fff; border-radius: 25px;" src="https://admin.ihealer.com/email_assets/images/2.png" alt="facebook" /></a>
							</li>
							<li style="display: inline-block; margin: 0 10px 0 0;">
								<a href="#"><img style="max-width: 35px; margin: 0; height: auto; display: inline-block; box-shadow: 0 5px 15px 0 #fff; border-radius: 25px;" src="https://admin.ihealer.com/email_assets/images/3.png" alt="facebook" /></a>
							</li>
						</ul>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>