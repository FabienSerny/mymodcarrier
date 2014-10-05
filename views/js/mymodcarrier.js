function mymodcarrier_load() {

	// Hide / Display relay point
	$('.delivery_option_radio').click(function() {
		mymodcarrier_carrier_selection();
	});

	// Save relay point selection
	$('.mymodcarrier_relay_point').click(function() {
		mymodcarrier_relaypoint_selection();
	});

	mymodcarrier_relaypoint_selection();
	mymodcarrier_carrier_selection();
}

function mymodcarrier_carrier_selection()
{
	// Hide relay point
	$('#delivery-options').hide();

	// Check all carrier input radio
	$('.delivery_option_radio').each(function() {

		// Check if the Relay Point carrier is selected
		if (!$(this).val().indexOf(id_carrier_relay_point) && $(this).prop('checked'))
			$('#delivery-options').show();

	});
}

function mymodcarrier_relaypoint_selection()
{
	// Check all relay point input radio
	$('.mymodcarrier_relay_point').each(function() {

		// Check if the Relay Point is selected
		if ($(this).prop('checked'))
		{
			$.ajax({
				type: "POST",
				url: mymodcarrier_ajax_link,
				data: { relay_point: $(this).val() },
				context: document.body
			});
		}

	});
}