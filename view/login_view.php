<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<form id="loginform" method="POST" action='_PROSES/action_proses.php'>
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="uname" type="text" id="username_txt" autofocus>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="upass" id="password_txt" type="password">
								
							<!--<div id='gif_proses' style="display:none"><img src="assets/img/load_gif.gif" style='width:30px' /></div>-->
						</div>
						    <input type="submit" name="action" class="btn btn-primary" id="login" value="Login" data-toggle="modal" data-target="#proses_modal">
							<label class="text-danger" style="font-size: 12pt;display:none;" id='pesan' ><i class="fa fa-times"></i> Failure</label>
						</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
				<img src="https://mir-s3-cdn-cf.behance.net/project_modules/disp/585d0331234507.564a1d239ac5e.gif" style='width:200px;margin-top:40%;margin-left:30%;background-color: transparent;' />
		  </div>
		</div>
	</div><!-- /.row -->
	<?php include ("process_modal_view.php"); ?>
</body>




