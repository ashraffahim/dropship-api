<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-body">
					<table class="table table-striped table-hover">
						<?php
						$i = 0;
						foreach ($data['data'] as $t) {
						$i++;
						?>

						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $t->oid; ?></td>
							<td><?php echo $t->pid; ?></td>
							<td><?php echo $t->cur . $t->amount; ?></td>
							<td><?php echo date('M d, Y', $t->otimestamp); ?></td>
							<td><?php echo date('M d, Y', $t->ptimestamp); ?></td>
							<td><?php echo $t->os.$t->ps; ?></td>
						</tr>
						
						<?php
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var st;
	$('.table tr').each(function() {
		st = $(this).find('td:eq(6)');
		switch (st.text()) {
			case '00':
				st.html('<span class="badge badge-light">Pending</span>');
				break;
				
			case '01':
				st.html('<span class="badge badge-secondary">Queued</span>');
				break;
				
			case '11':
				st.html('<span class="badge badge-success">Delivered</span>');
				break;
				
			case '10':
				st.html('<span class="badge badge-warning">Pending</span>');
				break;
		}
	});
</script>