<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:10px auto;width:780px;border:1px solid #aaa">
	<tbody>
		<tr>
			<td>
				<tr>
					<td style="background:#fff" align="left">
						<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
							<tbody>
								<tr style="background:#204e76">
									<td align="left" style="padding:10px 20px;color:#fff;font-size:26px"><img src="<?php echo url('/'); ?>/public/build/images/logo-light.png" style="filter: brightness(0) invert(1); width: 120px; margin-top: 5px;"></td>
								</tr>
								<tr>
									<td style="padding:8px 20px"> </td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>

				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#ccc" align="center">
					<tbody>
						<tr>
							<td width="100%" bgcolor="#ffffff" valign="top" style="padding: 0px 20px;">

								<h1 style="margin: 6px 0px; color: #204e76;">Forget Password ATGO</h1>
								<span style="font-size: 14px; margin-bottom: 8px; display: block; line-height: normal;">You can reset password from bellow link:</span>
								<p>You are receiving this email because we received a password reset request for your account.</p>
								<br>
								<span style="font-size: 14px; margin-bottom: 8px; display: block; line-height: normal;"> To Reset Your Password 
									<a href="<?php echo url('/'); ?>/password/reset/<?php echo $token ?>"><strong> Click Here </strong></a></span>
									<p>
									This password reset link will expire in 3 hours. </p>

									<p>If you did not request a password reset, no further action is required.</p><br>
									<strong>
										Regards, <br>
										ATGO
									</strong>

								</td>
							</tr>

						</tbody>
					</table>	 
				</td>
			</tr>
		</tbody>
	</table>