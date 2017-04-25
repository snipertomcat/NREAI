
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
	if (x !== 0) {
    	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	return 0;
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
				var weekly = parsed.weekly;
				var string = "";
				var table = "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>";
				//table start:
				table += '<div style="height: 150px; margin-left:200px;"><table border="1" class="uk-table uk-table-hover uk-table-condensed"><tbody>';
				//first row : market rates (cmr's):
				table += '<tr><td><span style="margin-top: 8px; margin-left:5px;">Market(%)</span></td><td><span style="margin-top: 6px" class="pull-left">'+cmr+'%</span></td>';
				//start weekly loop:
				jQuery.each(weekly, function(index, value) {
					if (value.direction == null) {
						string = '<td style=""><div style="width: 100%"><i class="" style="" aria-hidden="true"></i><span class="pull-right" style="margin-top: 8px;">'+value.cmr+'%</span></div></td>';
					} else {
						var color = (value.direction == 'positive' ? 'green' : 'red');
						if (color == 'green') {
							string = '<td style="color: green; "><span class="pull-left" style="margin-top: 8px">'+value.cmr+'%</span><i class="fa fa-chevron-circle-up pull-right" style="color:green; margin-top:-8px;" aria-hidden="true"></i></td>';
						} else if (color == 'red') {
							string = '<td style="color: red;"><span class="pull-left" style="margin-top: 8px">'+value.cmr+'%</span><i class="fa fa-chevron-circle-down pull-right" style="color: red; margin-top:-8px;" aria-hidden="true"></i></td>'
						}
					}
					table += string;
				});
/*				for (var i=0; i<=weekly.length; i++) {
					string = '<td>' + weekly[i].cmr + '%</td>';
				}*/
				//end loop
				table += '</tr>';
				//second row : adjusted rate (amr's + cmr's)
				table += '<tr><td>Adusted(%)</td><td>'+amr+'%</td>';
				//start loop
				jQuery.each(weekly, function(index, value) {
					var sum = value.amr + value.cmr;
					string = '<td>' + sum + '%</td>';
					table += string;
				});
				//end loop
				table += '</tr>';
				//third row : naavs
				table +='<tr><td>NAAV</td><td>$ '+naav+'</td>';
				//start loop
				if (typeof weekly[0].naav !== 'undefined') {
					jQuery.each(weekly, function(index, value) {
						string = '<td>$' + numberWithCommas(value.naav) + '</td>';
						table += string;
					});
				}
				//end loop
				table += '</tr>';
				//table end:
				table += '</tbody></table></div>';

				jQuery('#naav_result').html(naav);
				jQuery('#ticker_table').html(table);
			},
			type: 'POST'
		});
	});

	jQuery('#get_naav').click();
	
	//populate chart on page load IF there is nothing inside #naav_result
/*	jQuery.ajax({
		url: 'http://'+hostname+'/wp-content/plugins/nreai/lib/calcNaav.php',
		success: function(data) {
			var parsed = JSON.parse(data);
			var cmr = parsed.cmr;
			var amr = parsed.amr + cmr;
			var table = '<div style="height: 150px; margin-left:200px;"><table border="1" class="uk-table uk-table-hover uk-table-condensed"><tbody><tr><td>Market Rate(%)</td><td>'+cmr+'%</td></tr><tr><td>Adusted Rate(%)</td><td>'+amr+'%</td></tr></tbody></table></div>';
			jQuery('#ticker_table').html(table);
		},
		type: 'POST'
	});*/
}
