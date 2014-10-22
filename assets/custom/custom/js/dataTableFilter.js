
// execute when the HTML file's (document object model: DOM) has loaded
$(document).ready(function() {
	
	$('.form-dataproceed').click(
		function(e) 
		{
			
			// when the Web server responds to the request
			
			
			var SelectedItem = $('.form-horizontal').val();
			
			$.ajax(
			{
				url: "<?php echo site_url('main/ShowTable'); ?>",
				type: 'POST',
				async : false,
				dataType: "json",
				data: form.serialize(),
				success: function(data) { 
					$('.Gavno').append(data);
					console.log('sucessed data recieving');
				  //alert (data);
				}

			});
			
			e.preventDefault();
		}
	);
	
});