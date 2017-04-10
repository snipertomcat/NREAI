
// Theme JavaScript
function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function setText(id,newvalue) {
    var s= document.getElementById(id);
    s.innerHTML = newvalue;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

window.onload=function() {
	
	var hostname = window.location.hostname;
	
	//re-populate chart on button click:
	jQuery('#get_naav').click(function() {
		jQuery.ajax({
			url: 'http://'+hostname+'/wp-content/plugins/nreai/lib/calcNaav.php',
			data: {
				amount: jQuery('#loan_amount').val(),
			},
			error: function() {
				jQuery('#naav_result').html('<div class="uk-alert uk-alert-danger">An error occured.</div>');
			},
			success: function(data) {
				var parsed = JSON.parse(data);
				var naav = numberWithCommas(parsed.naav);
				var cmr = parsed.cmr;
				var amr = parsed.amr + cmr;
				var table = '<div style="height: 150px; margin-left:200px;"><table border="1" class="uk-table uk-table-hover uk-table-condensed"><tbody><tr><td>Market Rate(%)</td><td>'+cmr+'%</td></tr><tr><td>Adusted Rate(%)</td><td>'+amr+'%</td></tr><tr><td>NAAV</td><td>$ '+naav+'</td></tr></tbody></table></div>';
				jQuery('#naav_result').html(naav);
				jQuery('#ticker_table').html(table);
			},
			type: 'POST'
		});
	});
	
	//populate chart on page load IF there is nothing inside #naav_result
	jQuery.ajax({
		url: 'http://'+hostname+'/wp-content/plugins/nreai/lib/calcNaav.php',
		success: function(data) {
			var parsed = JSON.parse(data);
			var cmr = parsed.cmr;
			var amr = parsed.amr + cmr;
			var table = '<div style="height: 150px; margin-left:200px;"><table border="1" class="uk-table uk-table-hover uk-table-condensed"><tbody><tr><td>Market Rate(%)</td><td>'+cmr+'%</td></tr><tr><td>Adusted Rate(%)</td><td>'+amr+'%</td></tr></tbody></table></div>';
			jQuery('#ticker_table').html(table);
		},
		type: 'POST'
	});		
}
