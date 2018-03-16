jQuery(document).ready(function($){
       jQuery(".button").click(function(){
			var title = jQuery('select[name=title]').val();
			var authors = jQuery('select[name=authors]').val();
			var publisher = jQuery('select[name=publisher]').val();
			var price = jQuery('select[name=price]').val();
			//alert(title);
			jQuery.ajax({
			type:"POST",
			dataType: 'html',
			url: ajax_object.ajax_url,
			data: {
					'action': 'actionnew', //action calling to insert data in wordpress db...
					'title': title,
					'authors': authors,
					'publisher': publisher,
					'price': price
				},
			success:function(data){
				//alert(data);

				 document.getElementById("searchform").reset();
				 //jQuery('#searchform')[0].reset();

				console.log(data);
				jQuery("#users_data").html(data);
			},
			error: function(error) {
					//do something if fail
					console.log(error);
				}
			});
		});
});