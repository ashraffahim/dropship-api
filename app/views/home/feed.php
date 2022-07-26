<div class="container-fluid feed">
	<div class="row">

	<!-- Start Filter form -->
		<div class="col-md-2 text-muted">
		</div>

		<!-- End Filter form -->

		<!-- Start Feed -->

		<div class="col-md-12">
			
			<!-- Start Banner -->
			
			<div class="row mb-5">
				<div class="col-12">
					<div class="feed-banner">
						<div class="feed-banner-body">
							<h1>Lowest Price</h1>
							<h6>For the same quality</h6>
						</div>
					</div>
				</div>
			</div>

			<!-- End Banner -->

			<div class="row feed-items">
				<?php
				foreach ($data['data'] as $i => $p) {
				?>
				<div class="col-lg-3 col-md-5 col-sm-6">
					<a href="<?php echo BASEDIR.'/'.$p->id; ?>">
						<div class="card">
							<div class="card-thumb">
							<?php
							$fs = glob(DATADIR.DS.'product'.DS.$p->id.DS.'*');
							if (isset($fs[0])) {
								echo '<img src="'.DATA.DS.'product'.DS.$p->id.DS.basename($fs[0]).'" alt="'.$p->p_name.'" loading="lazy">';
							}
							?>
							</div>
							<div class="card-body">
								<h3 class="lead"><?php echo $p->p_name; ?></h3>
								<div class="fct"><span class="curr-symbol"><?php echo $p->currency_symbol; ?></span><?php echo $p->p_price; ?></div>
								<div class="text-muted"><?php echo $p->p_description; ?></div>
							</div>
						</div>
					</a>
				</div>
				<?php
				}
				?>
			</div>
		</div>

		<!-- End Feed -->

	</div>
</div>