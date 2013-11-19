<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
        <div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url('/home');?>"><?php echo $appName;?></a>
        </div>
        <div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li <?php if($this->uri->segment(1)=="home"){ echo "class='active'";} ?> >
					<a href="<?php echo site_url('/home');?>">
						<span class="glyphicon glyphicon-home"></span> Home
					</a>
				</li>
				<li <?php if($this->uri->segment(1)=="user"){ echo "class='active'";} ?> >
					<a href="<?php echo site_url('/user');?>">
						<span class="glyphicon glyphicon-user"></span> Users
					</a>
				</li>
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-cog"></span>
						<?php echo $fullUserName; ?><b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li><a href="#">Separated link</a></li>
						<li>
							<a href="<?php echo site_url('/auth/logout'); ?>">
								<span class="glyphicon glyphicon-off"></span> Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
        </div><!--/.nav-collapse -->
	</div>
</div>
<?php
/* End of file navBar.php */
/* Location:  ./application/views/components/navBar.php*/